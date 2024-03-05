<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DnpgFile extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid', 'keterangan', 'image_name', 'url', 'image', 'created_at',
    ];
}
