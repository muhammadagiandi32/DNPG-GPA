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
        'id','user_id', 'dnpg_no', 'created_at',
    ];
    public function images()
    {
        return $this->hasMany(Images::class, 'image_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
