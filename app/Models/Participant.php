<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'participants';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function users() {
        return $this->belongsToMany(User::class, 'user_participants', 'participant_id', 'user_id');
    }
}
