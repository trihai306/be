<?php

namespace App\Policies;

use App\Models\AccountFB;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountFBPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, AccountFB $model): bool
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

    public function update(User $user, AccountFB $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, AccountFB $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, AccountFB $model): bool
    {
        return false;
    }

    public function delete(User $user, AccountFB $model): bool
    {
        return false;
    }
}
