<?php

namespace App\Policies;

use App\Models\DepositHistory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepositHistoryPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, DepositHistory $model): bool
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

    public function update(User $user, DepositHistory $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, DepositHistory $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, DepositHistory $model): bool
    {
        return false;
    }

    public function delete(User $user, DepositHistory $model): bool
    {
        return false;
    }
}
