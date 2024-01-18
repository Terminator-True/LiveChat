<?php

namespace App\Custom\Chat;

use App\Models\Mensaje;
use App\Models\Chat;
use Carbon\Carbon;

class EliminarRegistrosBorrados
{
    /**
     * Funcín que elimina los registros que fueron "SOFT-DELETED"
     *
     * @return bool
     */
    public function eliminar(): bool
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
