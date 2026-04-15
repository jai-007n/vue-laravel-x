<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('room.{roomId}', function ($user,$roomId) {
    return \App\Models\Room::find($roomId)
        ->users()
        ->where('user_id', $user->id)
        ->exists();
});

// Broadcast::channel('room1', function ($user) {
//     return true;
// });
