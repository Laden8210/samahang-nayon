<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use Carbon\Carbon;

use App\Models\DiscountedRoom;
use App\Models\Promotion;

class RoomAPIController extends Controller
{
    public function getRoom(Request $request)
    {
        $checkIn = Carbon::parse($request->startDate);
        $checkOut = Carbon::parse($request->endDate);

        $rooms = Room::leftJoin('reservations', 'rooms.RoomId', '=', 'reservations.RoomId')
            ->leftJoin('discountedrooms', 'rooms.RoomId', '=', 'discountedrooms.RoomId')
            ->leftJoin('promotions', 'discountedrooms.PromotionId', '=', 'promotions.PromotionId')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereNull('reservations.RoomId')
                    ->orWhere('reservations.Status', 'Checked Out')
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('reservations.DateCheckOut', '<', $checkIn)
                              ->orWhere('reservations.DateCheckIn', '>', $checkOut);
                    });
            })
            ->select('rooms.*', 'promotions.Description as PromotionDescription', 'promotions.Discount', 'promotions.StartDate', 'promotions.EndDate')
            ->distinct()
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
