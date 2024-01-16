<?php

namespace App\Console\Commands;

use App\Custom\Chat\EliminarMensajesAntiguos;
use Illuminate\Console\Command;

class DeleteOldMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-old-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eliminarmos mensajes con antiguedad de 60 días';

    /**
     * Execute the console command.
     */
    public function handle(EliminarMensajesAntiguos $eliminarMensajesAntiguos)
    {
        $eliminarMensajesAntiguos->eliminar();
    }
}
