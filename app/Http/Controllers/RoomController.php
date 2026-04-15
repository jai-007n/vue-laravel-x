<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    //
    public function join(Room $room)
    {
        auth()->user()->rooms()->syncWithoutDetaching($room->id);

        return back();
    }

    public function leave(Room $room)
    {
        auth()->user()->rooms()->detach($room->id);

        return back();
    }

    public function send(Request $request, Room $room)
    {
        if (! $room->users->contains(auth()->id())) {
            abort(403);
        }

        $room->messages()->create([
            'user_id' => auth()->id(),
            'message' => "Hello i am user " . auth()->id(),
        ]);

        broadcast(new MessageSent([
            'user_id' => auth()->id(),
            'message' => "Hello i am user " . auth()->id(),
            'roomId' => $room->id
        ]))->toOthers();

        return "successfully hit the send !!!!";
    }
}
