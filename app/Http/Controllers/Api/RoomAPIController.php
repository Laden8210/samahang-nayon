<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use Carbon\Carbon;

class RoomAPIController extends Controller
{

    public function getRoom(Request $request)
    {
        $checkIn = $request->checkIn;
        $checkOut = $request->checkOut;


        $checkIn = Carbon::parse($checkIn);
        $checkOut = Carbon::parse($checkOut);

        $rooms =  Room::leftJoin('reservations', 'rooms.RoomId', '=', 'reservations.RoomId')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereNull('reservations.RoomId') // Room has no reservation
                    ->orWhere('reservations.Status', 'Checked Out') // Reservation has checked out
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('reservations.DateCheckOut', '<', $checkIn)
                            ->orWhere('reservations.DateCheckIn', '>', $checkOut); // Reservation check-in is after the new check-out
                    });
            })
            ->select('rooms.*')
            ->get();

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


    public function searchRoom(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $test = 'test';

        $rooms = Room::all();

        return response()->json($rooms);
    }
}
