<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Image;

class Photo extends Model
{
    protected $fillable = ['image'];
    protected $dimensions = [
        'original' => null,
        'medium' => 300,
        'thumb' => 100
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function resizeAndSave($file) {
        foreach ($this->dimensions as $dimension => $width) {
            $file->storeAs("public/photos/{$this->id}/{$dimension}", $this->image);

            $image = Image::make(
                public_path($this->path("original"))
            );

            if (isset($width)) {
                $image->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            $image->save(
                public_path($this->path($dimension))
            );
        }
    }

    public function path($dimension)
    {
        return "storage/photos/{$this->id}/{$dimension}/{$this->image}";
    }
}
