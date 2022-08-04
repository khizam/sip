<?php

namespace App\Services;

use App\Models\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class NotificationService
{
    public static function getNotificationUser(User $user): array
    {
        $unread = $user->unreadNotifications;
        $totalUnread = $unread->isNotEmpty() ? $unread->count() : 0;
        return compact('unread', 'totalUnread');
    }

    public static function getUserByRole($role)
    {
        return User::role($role);
    }
}
