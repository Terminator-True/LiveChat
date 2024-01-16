<?php

namespace App\Custom\Chat;

use App\Models\Mensaje;
use Carbon\Carbon;

class EliminarMensajesAntiguos
{
    public function eliminar()
    {
        $antiguedad_limite = Carbon::now()->subDays(60);
        Mensaje::query()
                        ->where('id','>',0)
                        ->where('created_at','<=',$antiguedad_limite)
                        ->each(function ($value, $key){
                            $value->forceDelete();
                        });
        return true;
    }
}
