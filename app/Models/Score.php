<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $table = 'scores';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }
}
