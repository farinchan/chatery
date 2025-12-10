<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $guarded = [
        'id'
    ];

    public function teamUsers()
    {
        return $this->hasMany(TeamUser::class);
    }

    public function getlogo()
    {
        if ($this->logo && (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://'))) {
            return $this->logo;
        }
        return $this->logo ? asset('storage/' . $this->logo) : "https://ui-avatars.com/api/?background=15365F&color=C3A356&size=128&name=" . $this->name;
    }
}
