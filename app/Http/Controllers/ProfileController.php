<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //
    public function userPosts(){
        return view('client.pages.profile.posts', [
            'posts' => Post::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(5),
        ]);
    }
    public function profileEdit(){
        $user = Auth::user();
        return view('client.pages.profile.edit', [
            'user' => $user,
            'userRole' => $user->role,
            'roles' => Role::all(),
        ]);
    }
    public function update(UpdateProfileRequest $request, User $user){
//        dd($request->all());
        $user->update([
            'name' => $request->user_name,
            'updated_at' => now(),
        ]);
        if (!empty($request->old_user_password)) {
            if (Hash::check($request->old_user_password, Auth::user()->password)) {
                $user->update([
                    'password' => Hash::make($request->new_user_password),
                ]);
            } else {
                return redirect()->route('user.page.profile.edit')->withErrors(['old_user_password' => 'Wrong password']);
            }
        }
        return redirect(route('user.page.profile'))
            ->with(['success' => "Successfully updated"]);
    }
}
