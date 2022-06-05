<?php

namespace App\Listeners;

use App\Events\PostSaving;
use App\Mail\NewPostFromYourFavoriteAuthor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NotifyFollowerOfNewPost
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\PostSaving  $event
     * @return void
     */
    public function handle(PostSaving $event)
    {
        // skip when new post is saved as draft
        if ($event->post->status === 'DRAFT') {
            return;
        }

        // skip when the post is already published before
        if ($event->post->getRawOriginal('status') === 'PUBLISHED') {
            return;
        }

        // send an email to author's followers
        $followers = $event->post->author->followers;
        foreach($followers as $follower) {
            Mail::to($follower->email)->send(new NewPostFromYourFavoriteAuthor($event->post));
        }
    }
}
