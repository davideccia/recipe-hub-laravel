<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasReviews
{
    public function reviews(): MorphMany;

    public function notifiableReviewUser(): User;
}
