<?php

namespace App\Listeners;

use App\Models\User;
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

        // Note: since Eloquent dispatchesEvents only observe changes in Post model's properties, such as `if ($event->post->isDirty('user_id'))`
        // any non property like relationship, eg. author() will not be reflected in time when the change happens
        // Hence, `$followers = $event->post->author->followers;` will return the follower list from old author

        $followers = User::find($event->post->user_id)->followers;
        foreach($followers as $follower) {
            Mail::to($follower->email)->send(new NewPostFromYourFavoriteAuthor($event->post));
        }
    }
}
