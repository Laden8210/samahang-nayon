<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomAPIController extends Controller
{

    public function getRoom(Request $request){

        if($request->has('room_id')){
            $room = Room::find($request->room_id);
            return response()->json($room);
        }

        $rooms = Room::all();
        return response()->json($rooms);
    }

    public function getImage(Request $request)
    {
        $room = Room::find($request->room_id);
        if ($room && $room->roomPictures->first()) {
            $picture = $room->roomPictures->first();
            $base64Image = base64_encode($picture->PictureFile);
            return response()->json([
                'image' => $base64Image,
                'mime_type' => $picture->mime_type
            ]);
        }
        return response()->json(['error' => 'Room or image not found'], 404);
    }

}
