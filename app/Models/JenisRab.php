<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisRab extends Model
{
    use HasFactory;
    protected $table = 'jenis_rab';
    protected $guarded = [
        'id'
    ];
}
