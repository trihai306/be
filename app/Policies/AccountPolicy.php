<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Account $model): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return true;
    }

    public function storeBulk(User $user): bool
    {
        return true;
    }

    public function update(User $user, Account $model): bool
    {
        return true;
    }

    public function updateBulk(User $user, Account $model): bool
    {
        return true;
    }

    public function deleteBulk(User $user, Account $model): bool
    {
        return true;
    }

    public function delete(User $user, Account $model): bool
    {
        return true;
    }
}
