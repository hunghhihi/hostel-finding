<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Hostel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class HostelPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('hostels.view.any');
    }

    public function viewOwn(User $user): Response|bool
    {
        return true;
    }

    public function view(User $user, Hostel $hostel): Response|bool
    {
        return $hostel->owner_id === $user->id || $this->viewAny($user);
    }

    public function create(User $user): Response|bool
    {
        return $user->hasPermissionTo('hostels.create.any');
    }

    public function update(User $user, Hostel $hostel): Response|bool
    {
        return $user->hasPermissionTo('hostels.update.any') || $user->id === $hostel->owner_id;
    }

    public function subscribe(User $user, Hostel $hostel): Response|bool
    {
        return $hostel->subscribers()->wherePivot('user_id', $user->id)->doesntExist();
    }

    public function deleteAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('hostels.delete.any');
    }

    public function delete(User $user, Hostel $hostel): Response|bool
    {
        return $user->id === $hostel->owner_id || $this->deleteAny($user);
    }
}
