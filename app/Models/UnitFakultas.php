<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitFakultas extends Model
{
    use HasFactory;

    protected $table = 'unit_fakultas';

    protected $fillable = ['nama'];
}
