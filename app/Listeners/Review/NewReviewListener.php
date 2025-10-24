<?php

namespace App\Listeners\Review;

use App\Contracts\HasReviews;
use App\Events\Review\NewReviewEvent;
use App\Notifications\Review\NewReviewNotification;

class NewReviewListener
{
    public function __construct()
    {
        //
    }

    public function handle(NewReviewEvent $event): void
    {
        /** @var HasReviews $reviewable */
        $reviewable = $event->review->reviewable;

        $reviewable->notifiableReviewUser()->notify(new NewReviewNotification($event->review));
    }
}
