<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DnpgFile extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = [
        'id', 'user_id', 'dnpg_no', 'created_at',
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
    public function images()
    {
        return $this->hasMany(Images::class, 'image_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
