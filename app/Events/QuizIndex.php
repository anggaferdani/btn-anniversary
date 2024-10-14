<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizIndex implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $quizIndex;

    public function __construct($quizIndex)
    {
        $this->quizIndex = $quizIndex;
    }

    public function broadcastOn()
    {
        return new Channel ('quiz-index');
    }

    public function broadcastAs()
    {
        return 'quiz-index';
    }
}
