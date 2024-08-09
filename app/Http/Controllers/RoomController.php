<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{

    public function index()
    {
        return view('admin.room.index');
    }

    public function create(Request $request)
    {

        $room = new Room();
        $room->description = $request->description;
        $room->room_number = $request->room_number;
        $room->room_type = $request->room_type;
        $room->room_rate = $request->room_rate;
        $room->room_status = $request->room_status;
        $room->save();

        return redirect()->route('rooms') ;
    }

    public function addRoom()
    {
        return view('admin.room.add');
    }

}
