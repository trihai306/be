<?php

namespace App\Policies;

use App\Models\MoneyTransfer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MoneyTransferPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, MoneyTransfer $model): bool
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

    public function update(User $user, MoneyTransfer $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, MoneyTransfer $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, MoneyTransfer $model): bool
    {
        return false;
    }

    public function delete(User $user, MoneyTransfer $model): bool
    {
        return false;
    }
}
