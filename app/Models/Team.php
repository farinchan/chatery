<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'package_expires_at' => 'datetime',
    ];

    public function teamUsers()
    {
        return $this->hasMany(TeamUser::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function getlogo()
    {
        if ($this->logo && (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://'))) {
            return $this->logo;
        }
        return $this->logo ? asset('storage/' . $this->logo) : "https://ui-avatars.com/api/?background=15365F&color=C3A356&size=128&name=" . $this->name;
    }

    /**
     * Check if team has active package
     */
    public function hasActivePackage()
    {
        if (!$this->package_id) {
            return false;
        }

        if ($this->package_expires_at && $this->package_expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Check if package is expired
     */
    public function isPackageExpired()
    {
        if (!$this->package_expires_at) {
            return false; // Lifetime package
        }

        return $this->package_expires_at->isPast();
    }

    /**
     * Get days until package expires
     */
    public function getDaysUntilExpiry()
    {
        if (!$this->package_expires_at) {
            return null; // Lifetime
        }

        return now()->diffInDays($this->package_expires_at, false);
    }

    /**
     * Check if team can add more members
     */
    public function canAddMember()
    {
        if (!$this->package) {
            return false;
        }

        $maxMembers = $this->package->max_members;
        if ($maxMembers === -1) {
            return true; // Unlimited
        }

        return $this->teamUsers()->count() < $maxMembers;
    }

    /**
     * Check feature availability
     */
    public function hasFeature($feature)
    {
        if (!$this->package) {
            return false;
        }

        $featureField = 'has_' . $feature;
        return $this->package->{$featureField} ?? false;
    }

    /**
     * Get limit value
     */
    public function getLimit($limitField)
    {
        if (!$this->package) {
            return 0;
        }

        return $this->package->{$limitField} ?? 0;
    }
}
