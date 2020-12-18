<?php


namespace App\Services;


use Carbon\Carbon;
use Intervention\Image\Facades\Image;

class FileUploader
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
