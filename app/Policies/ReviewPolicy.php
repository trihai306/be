<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Review $model): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return false;
    }

    public function storeBulk(User $user): bool
    {
        return false;
    }

    public function update(User $user, Review $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, Review $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, Review $model): bool
    {
        return false;
    }

    public function delete(User $user, Review $model): bool
    {
        return false;
    }
}
