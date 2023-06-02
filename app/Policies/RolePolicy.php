<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, Role $model): bool
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

    public function update(User $user, Role $model): bool
    {
        return true;
    }

    public function updateBulk(User $user, Role $model): bool
    {
        return true;
    }

    public function deleteBulk(User $user, Role $model): bool
    {
        return true;
    }

    public function delete(User $user, Role $model): bool
    {
        return true;
    }
}
