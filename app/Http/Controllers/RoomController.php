<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\RoomPictures;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class RoomController extends Controller
{

    public function index()
    {
        return view('admin.room.index');
    }

    public function addRoom()
    {
        return view('admin.room.add');
    }

    public function updateRoom($roomId)
    {
        try {
            $decryptedId = Crypt::decrypt($roomId);
            $room = Room::findOrFail($decryptedId);
            return view('admin.room.update', compact('room'));
        } catch (DecryptException $e) {
            return redirect()->route('admin.room.index')->with('error', 'Invalid Room ID.');
        }
    }

    public function getRoomList()
    {
        $rooms = Room::with('roomPictures')->get();

        $roomsWithImages = $rooms->map(function ($room) {
            // Convert each room's pictures to base64
            $pictures = $room->roomPictures->map(function ($picture) {
                // Ensure you are storing the correct relative path in the database
                // Adjust this path as necessary based on where your images are stored
                $filePath = storage_path('app/public/' . $picture->PictureFile);

                // Check if the file exists and is valid
                if (file_exists($filePath) && !is_null($picture->PictureFile)) {
                    return [
                        'id' => $picture->id,
                        'PictureFile' => 'data:image/jpeg;base64,' . base64_encode(file_get_contents($filePath)),
                    ];
                }
                return [
                    'id' => $picture->id,
                    'PictureFile' => null, // Handle missing or invalid files
                ];
            });

            return [
                'RoomId' => $room->RoomId,
                'RoomNumber' => $room->RoomNumber,
                'RoomType' => $room->RoomType,
                'Capacity' => $room->Capacity,
                'Description' => $room->Description,
                'Status' => $room->Status,
                'Pictures' => $pictures,
            ];
        });

        return response()->json($roomsWithImages);
    }


    public function getImage()
    {
        $images = RoomPictures::all();

        $imagesWithBase64 = $images->map(function ($image) {
            return [
                'RoomPictureId' => $image->RoomPictureId,
                'RoomId' => $image->RoomId,
                'PictureFile' => base64_encode($image->PictureFile),
            ];
        });

        return response()->json($imagesWithBase64);

    }



}
