<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPostFromYourFavoriteAuthor extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The post instance.
     *
     * @var App\Models\Post
     */
    public $post;

    /**
     * Create a new message instance.
     * Note: this Mailable class receives one parameter which is a Post instance
     *
     * @param App\Models\Post $order
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.followings.post', [
                        'title' => $this->post->title,
                        'excerpt' => $this->post->excerpt,
                        'author' => User::find($this->post->user_id)->name,
                        'url' => env('APP_URL') . '/post/' . $this->post->slug,
                    ]);
    }
}
