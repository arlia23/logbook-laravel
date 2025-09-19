<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Monitoring extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'minggu_mulai',
        'minggu_selesai',
        'catatan_supervisor'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 
