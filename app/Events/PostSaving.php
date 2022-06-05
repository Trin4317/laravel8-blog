<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostSaving
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The post instance.
     *
     * @var App\Models\Post
     */
    public $post;

    /**
     * Create a new event instance.
     * Note: this event class is a container for Post instance when Eloquent dispatches an event,
     * which means it has access to all data inside the $post
     *
     * @param App\Models\Post $order
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
