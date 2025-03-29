<?php
namespace App\Traits;

use App\Models\Mensaje;
trait UploadImage
{
    public function uploadImage(String $base64Image, Mensaje $message): Bool
    {
        $message->image()->create(['data' => $base64Image]);

        if ($message->image()->exists()) {
            return true;
        }
        return false;
    }
}


?>