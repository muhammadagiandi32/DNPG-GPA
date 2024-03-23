<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id','image_id','keterangan','image_name','url', 'created_at',
    ];
    public function dnpgFile()
    {
        return $this->belongsTo(DnpgFile::class, 'image_id','id');
    }
}
