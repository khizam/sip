<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $unread = Auth::user()->unreadNotifications;
        $totalUnread = $unread->isNotEmpty() ? Auth::user()->unreadNotifications->count() : 0;
        return jsonResponse(compact('unread','totalUnread'));
    }
}
