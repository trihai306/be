<?php

namespace App\Policies;

use App\Models\Proxy;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProxyPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Proxy $model): bool
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

    public function update(User $user, Proxy $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, Proxy $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, Proxy $model): bool
    {
        return false;
    }

    public function delete(User $user, Proxy $model): bool
    {
        return false;
    }
}
