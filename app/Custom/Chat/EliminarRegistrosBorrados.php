<?php

namespace App\Custom\Chat;

use App\Models\Mensaje;
use App\Models\Chat;
use Carbon\Carbon;

class EliminarRegistrosBorrados
{
    public function eliminar()
    {
        Mensaje::onlyTrashed()
                        ->each(function ($value, $key){
                            $value->forceDelete();
                        });
        Chat::onlyTrashed()
                        ->each(function ($value, $key){
                            $value->forceDelete();
                        });
        return true;
    }
}
