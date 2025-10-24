<?php

namespace App\Observers;

use App\Events\Review\NewReviewEvent;
use App\Models\Review;

class ReviewObserver
{
    public function creating(Review $review): void
    {
        //
    }

    public function created(Review $review): void
    {
        event(new NewReviewEvent($review->loadMissing('user')));
    }

    public function updating(Review $review): void
    {
        //
    }

    public function updated(Review $review): void
    {
        //
    }

    public function saving(Review $review): void
    {
        //
    }

    public function saved(Review $review): void
    {
        //
    }

    public function deleting(Review $review): void
    {
        //
    }

    public function deleted(Review $review): void
    {
        //
    }
}
