<?php

namespace App\Policies;

use App\Models\InforFacebook;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InforFacebookPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, InforFacebook $model): bool
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

    public function update(User $user, InforFacebook $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, InforFacebook $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, InforFacebook $model): bool
    {
        return false;
    }

    public function delete(User $user, InforFacebook $model): bool
    {
        return false;
    }
}
