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
        // Parse check-in and check-out dates
        $checkIn = Carbon::parse($request->checkIn);
        $checkOut = Carbon::parse($request->checkOut);

        // Calculate total guests
        $adults = $request->adult;
        $children = $request->children;
        $totalGuests = $adults + $children;



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
            ->get()
            ->values();


        if ($totalGuests > 0) {
            $rooms = $rooms->filter(function ($room) use ($totalGuests) {
                return $room->Capacity >= $totalGuests;
            })->values();
        }

        if ($rooms->isEmpty()) {
            return response()->json(['error' => 'No available rooms'], 200);
        }

        $bookedRooms = Room::leftJoin('reservations', 'rooms.RoomId', '=', 'reservations.RoomId')
            ->where('reservations.Status', 'Checked In')
            ->where(function ($query) use ($checkIn, $checkOut) {
                // Booked if dates overlap with check-in/check-out
                $query->whereBetween('reservations.DateCheckIn', [$checkIn, $checkOut])
                    ->orWhereBetween('reservations.DateCheckOut', [$checkIn, $checkOut])
                    ->orWhere(function ($query) use ($checkIn, $checkOut) {
                        $query->where('reservations.DateCheckIn', '<=', $checkIn)
                              ->where('reservations.DateCheckOut', '>=', $checkOut);
                    });
            })
            ->select('rooms.RoomId')
            ->distinct()
            ->pluck('RoomId'); // Get only RoomIds


        $availableRooms = $rooms->reject(function ($room) use ($bookedRooms) {
            return $bookedRooms->contains($room->RoomId);
        })->values();


        if ($availableRooms->isEmpty()) {
            return response()->json(['error' => 'No available rooms'], 200);
        }

        return response()->json($availableRooms);
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
