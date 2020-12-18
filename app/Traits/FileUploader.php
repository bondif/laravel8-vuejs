<?php


namespace App\Traits;


use Carbon\Carbon;
use Intervention\Image\Facades\Image;

trait FileUploader
{
    public function uploadBase64($file): string
    {
        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':',
                substr($file, 0, strpos($file, ';')))[1])[1];

        $filePath = 'images/' . $fileName;
        Image::make($file)->save($filePath);

        return $filePath;
    }
}
