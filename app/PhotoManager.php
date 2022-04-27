<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PhotoManager
{
    /**
     * @param Object $photo Request image
     * @param string $path  Where the image is going i.e. profile
     * @param string $oldName Image to be deleted in same folder
     * 
     * @return string Name of the file in the directory or null
     * 
     */
    public static function savePhoto(
        $photo, string $path = 'profile', $oldName = null
    ): string
    {
        $fileName = time() . '.' . $photo->getClientOriginalExtension();
                

            $img = Image::make($photo->getRealPath());
            $img->resize(120, 120);

            $img->stream();

            $storage = Storage::disk('local')
                ->put("public/images/$path/$fileName", $img, 'public');
            
            if ($storage) {
                if ($oldName) {
                    Storage::disk('local')
                        ->delete("public/images/$path/".$oldName);
                }
                return $fileName;
            }
            return null;
    }
}