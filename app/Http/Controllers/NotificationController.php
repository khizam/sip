<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        return jsonResponse($this->notications());
    }

    public function show()
    {
        $role = Auth::user()->roles->pluck('id');
        $notifications = Notifications::where('notifiable_id', $role)
                            ->orderBy('created_at','DESC')
                            ->paginate(10);
        return view('notification.index', compact('notifications'));
    }

    public function notications()
    {
        $unread = Auth::user()->unreadNotifications;
        $totalUnread = $unread->isNotEmpty() ? Auth::user()->unreadNotifications->count() : 0;
        return compact('unread','totalUnread');
    }

    public function markAsRead(Notifications $notifications, bool $redirect = false)
    {
        $redirectTo = json_decode($notifications->data)->links;
        if (is_null($notifications->read_at)) {
            $notifications->markAsRead();
        }
        if ($redirect && $redirectTo != '') {
            return redirect($redirectTo);
        }
        return redirect()->route('notifications.show');
    }
}
