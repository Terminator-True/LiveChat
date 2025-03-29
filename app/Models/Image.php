<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;


    use HasFactory,SoftDeletes;

    protected $table = 'images';
    protected $fillable = [
        'data',
        'message_id',
    ];

    public function message()
    {
        return $this->belongsTo(Mensaje::class);
    }
}
