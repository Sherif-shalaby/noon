<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    // +++++++++++++++++++++++++++++++++ Mark All notifications As Read +++++++++++++++++++++++++++++++++
    public function markAsRead()
    {
        // Get "user" which have "unread notifications"
        $user = User::findOrFail( auth()->user()->id );
        // Make All notifications "mark as read"
        foreach ( $user->unreadNotifications as $notificationVar )
        {
            $notificationVar->markAsRead();
        }
        // Go To "back page"
        return redirect()->back();
    }
    // +++++++++++++++++++++++++++++++++ Delete "Notification" +++++++++++++++++++++++++++++++++
    public function destroy_notification($notificationId)
    {
        Notification::where('id', $notificationId)->delete();
        $output = [
            'success' => true,
            'msg' => __('lang.delete_notification')
        ];
        return redirect()->back()->with('status', $output);
     }
}
