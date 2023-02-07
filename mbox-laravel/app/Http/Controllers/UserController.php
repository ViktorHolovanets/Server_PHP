<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $user = Auth::user()->makeVisible(['email',]);
        $followers = $user->followers()
            ->offset(0)
            ->limit(5)
            ->get() ?? '';
        $followings = $user->followings()
            ->offset(0)
            ->limit(5)
            ->get() ?? '';

        return response()->json([
            'user' => $user,
            'followers' => $followers,
            'followings' => $followings,
        ]);
    }

    public function followers()
    {
        return response()->json([Auth::user()->followers]);
    }

    public function followings()
    {
        return response()->json([Auth::user()->followings]);
    }

    public function show(User $user)
    {
        return response($user);
    }


    public function update(UpdateRoleRequest $request, User $role)
    {
        //
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('logout');
    }

    public function toggleFollow(User $user)
    {
        $u = Auth::user();
        $followings = $user->followers()->where('id', $u->id)->first();
        if (is_null($followings)) {
            $user->followers()->attach($u->id);
        } else {
            $user->followers()->detach($u->id);
        }
        return response($user);
    }
}
