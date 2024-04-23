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
        'id', 'image_id', 'keterangan', 'image_name', 'url', 'created_at',
    ];
    protected static function booted()
    {
        static::creating(function ($model) {
            // Cari nomor terbesar saat ini
            $latestNumber = static::max('no');

            // Jika tidak ada nomor sebelumnya, mulai dari 1, jika tidak, tambahkan 1
            $model->no = $latestNumber ? $latestNumber + 1 : 1;
        });
    }
    public function dnpgFile()
    {
        return $this->belongsTo(DnpgFile::class, 'image_id', 'id');
    }
}
