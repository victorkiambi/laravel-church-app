<?php

namespace App\Http\Controllers;

use App\Models\AppUser;
use Illuminate\Http\Request;

class AppUserController extends Controller
{
    //Get all users
    public function index()
    {
        return AppUser::paginate(10);
    }

    //Get a user by id
    public function show($id)
    {
        return AppUser::find($id);
    }

    //Create a new user
    public function store(Request $request)
    {
        return AppUser::create($request->all());
    }

    //Update a user
    public function update(Request $request, $id)
    {
        $user = AppUser::findOrFail($id);
        $user->update($request->all());

        return $user;
    }
}
