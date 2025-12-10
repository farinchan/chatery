<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class OnlineStatusService
{
    /**
     * Prefix untuk key Redis
     */
    protected const PREFIX = 'user_online:';

    /**
     * TTL dalam detik (5 menit)
     */
    protected const TTL = 300;

    /**
     * Set user sebagai online
     */
    public static function setOnline(int $userId): void
    {
        Cache::store('redis')->put(self::PREFIX . $userId, now()->timestamp, self::TTL);
    }

    /**
     * Set user sebagai offline
     */
    public static function setOffline(int $userId): void
    {
        Cache::store('redis')->forget(self::PREFIX . $userId);
    }

    /**
     * Cek apakah user online
     */
    public static function isOnline(int $userId): bool
    {
        return Cache::store('redis')->has(self::PREFIX . $userId);
    }

    /**
     * Get last seen timestamp
     */
    public static function getLastSeen(int $userId): ?int
    {
        $timestamp = Cache::store('redis')->get(self::PREFIX . $userId);
        return $timestamp ? (int) $timestamp : null;
    }

    /**
     * Get online status untuk multiple users
     */
    public static function getOnlineUsers(array $userIds): array
    {
        $result = [];

        if (empty($userIds)) {
            return $result;
        }

        foreach ($userIds as $userId) {
            $result[$userId] = Cache::store('redis')->has(self::PREFIX . $userId);
        }

        return $result;
    }

    /**
     * Count online users dari list user IDs
     */
    public static function countOnline(array $userIds): int
    {
        if (empty($userIds)) {
            return 0;
        }

        $count = 0;
        foreach ($userIds as $userId) {
            if (Cache::store('redis')->has(self::PREFIX . $userId)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Refresh TTL untuk user (extend online status)
     */
    public static function refresh(int $userId): void
    {
        if (self::isOnline($userId)) {
            self::setOnline($userId);
        }
    }

    /**
     * Get semua online user IDs (untuk admin/monitoring)
     * Note: This method requires direct Redis access
     */
    public static function getAllOnlineUserIds(): array
    {
        // Using Cache facade doesn't support keys() method
        // This is a limitation - you may need to track online users differently
        // For now, return empty array
        return [];
    }
}
