<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = NotificationService::getNotificationUser($user);
        return jsonResponse($notifications);
    }

    public function show($read_at = '')
    {
        $user_id = Auth::user()->id;
        $notifications = Notifications::where('notifiable_id', $user_id)
            ->when($read_at == 'read', function ($query) {
                $query->whereNotNull('read_at');
            })
            ->when($read_at == 'unread', function ($query) {
                $query->whereNull('read_at');
            })
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        if (request()->ajax()) {
            return view('notification.load_content', compact('notifications'));
        }
        return view('notification.index', compact('notifications'));
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
