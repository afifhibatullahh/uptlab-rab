<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisItem extends Model
{
    use HasFactory;
    protected $table = 'jenis_item';
    protected $guarded = [
        'id'
    ];
}
