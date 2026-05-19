<?php

use App\Models\Notification;

if (!function_exists('sendNotification')) {
    function sendNotification($userId, $message, $link = null)
    {
        if (!$userId) {
            return;
        }

        Notification::create([
            'user_id' => $userId,
            'message' => $message,
            'link' => $link,
            'is_read' => false,
        ]);
    }
}