<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Room;
use App\Photo;

class PhotoController extends Controller
{
    public function store(Request $request, Room $room)
    {   
        if ($request->hasFile('photos')) {
            $files = $request->file('photos');

            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();

                if ($photo = $room->photos()->create(['image' => $filename])) {
                    $photo->resizeAndSave($file);
                }
            }
        } else {
            toastr()->error("No selected photos.");
            return back();
        }

        toastr()->success("Upload successful!");
        return back();
    }

    public function destroy(Room $room, Photo $photo)
    {
        //
    }
}
