<?php

namespace App\Http\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getAll()
    {
        $userAuth = Auth::user();
        if ($userAuth->isOrganization()) {
            $organization = $userAuth->organization;
            $allUsers = $organization->users;
            return $allUsers;
        }
        //user lists without admin
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', Role::ROLE_ADMIN);
        })->get();
        return $users;
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $user;
    }
    public function store($request)
    {
        $user = new User();
        $user->organization_id = $request->organization_id;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->date_of_birth = $request->date_of_birth;
        $user->address = $request->address;
        $user->password = bcrypt($request->password);
        $user->save();
        return $user;
    }
}
