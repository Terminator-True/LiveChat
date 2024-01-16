<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Custom\Chat\EliminarRegistrosBorrados;

class DeleteSoftDeletedRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-soft-deleted-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina registros soft deleted';

    /**
     * Execute the console command.
     */
    public function handle(EliminarRegistrosBorrados $eliminar)
    {
        $eliminar->eliminar();
    }
}
