<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Image;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    protected $fillable = ['image'];
    protected $dimensions = [
        'original' => null,
        'medium' => 300,
        'thumb' => 100
    ];

    protected static function boot() {
        parent::boot();

        static::deleted(function($photo) {
            Storage::disk('s3')->deleteDirectory("photos/{$photo->id}");
        });
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function resizeAndSave($file) {
        foreach ($this->dimensions as $dimension => $width) {
            $image = Image::make($file);

            if (isset($width)) {
                $image->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }

            Storage::disk('s3')->put("photos/{$this->id}/{$dimension}/{$this->image}", $image->encode(), 'public');
        }
    }

    public function path($dimension)
    {
        return "photos/{$this->id}/{$dimension}/{$this->image}";
    }
}
