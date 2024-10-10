<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'instansis';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }
}
