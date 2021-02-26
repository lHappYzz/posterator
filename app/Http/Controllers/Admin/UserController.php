<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        //
        return view('admin.users.index', [
            'users' => User::orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //
        return view('admin.users.create', [
            'roles' => Role::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreUserRequest $request)
    {
        //
//        dd($request);
        $role = DB::table('roles')->where('name', $request->role_name)->first();
        $user = User::create([
            'name' => $request->user_name,
            'role_id' => $role->id,
            'email' => $request->user_email,
            'password' => Hash::make($request->user_password),
        ]);

        return redirect(route('admin.user.index'))
            ->with(['success' => "'{$user->name}' successfully created"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function show(User $user)
    {
        //
        return redirect(route('admin.user.index'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return View
     */
    public function edit(User $user)
    {
        //
        return view('admin.users.update', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
        $role = DB::table('roles')->where('name', $request->role_name)->first();
        $user->update([
            'name' => $request->user_name,
            'role_id' => $role->id,
            'email' => $request->user_email,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        if (!empty($request->user_password)){
            $user->update([
                'password' => Hash::make($request->user_password),
            ]);
        }

        return redirect(route('admin.user.index'))
            ->with(['success' => "'{$user->name}' successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return RedirectResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
        } catch (\Exception $e) {
            return back('Something went wrong')->withInput();
        }

        return redirect(route('admin.user.index'))
            ->with(['success' => "'{$user->name}' successfully deleted"]);
    }
}
