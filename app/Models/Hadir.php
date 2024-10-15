<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hadir extends Model
{
    use HasFactory;

    protected $table = 'hadirs';

    protected $primaryKey = 'id';

    protected $guarded = [];
}
