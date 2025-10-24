<?php

namespace App\Policies;

use App\Models\MeasurementUnit;
use App\Models\User;

class MeasurementUnitPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->manageApplication()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, MeasurementUnit $measurementUnit): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->manageApplication();
    }

    public function update(User $user, MeasurementUnit $measurementUnit): bool
    {
        return $user->manageApplication();
    }

    public function delete(User $user, MeasurementUnit $measurementUnit): bool
    {
        return $user->manageApplication();
    }
}
