<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\UserAssignment;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (Gate::allows('isAdministrator') || Gate::allows('isAuthor')) {
            if ($search = \Request::get('query')) {
                $users = User::where(function($query) use ($search){
                    $query->where('name', 'LIKE', '%'.$search.'%')
                            ->orWhere('email', 'LIKE', '%'.$search.'%')
                            ->orWhere('role', 'LIKE', '%'.$search.'%');
                })->paginate(15);
            } else {
                $users = User::latest()->paginate(15);
            }

            return new UserResource($users);
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('isAdministrator');
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required'
        ]);
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'landline' => $request['landline'],
            'role' => $request['role'],
            'avatar' => 'profile.png',
            'status' => 'Active',
        ]);
        if ($request->department_id != '') {
            UserAssignment::create([
                'user_id' => $user->id,
                'department_id' => $request->department_id
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return auth('api')->user();
    }

    public function updateProfile(Request $request) {
        $user = auth('api')->user();

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|confirmed|min:6'
        ]);

        $currentPhoto = $user->avatar;

        if ($request->avatar != $currentPhoto) {
            $name = time() . '.' . explode('/', explode(':', substr($request->avatar, 0, strpos($request->avatar, ';')))[1])[1];
            \Image::make($request->avatar)->save(public_path('storage/user_avatars/').$name);

            $request->merge(['avatar' => $name]);

            $userPhoto = public_path('storage/user_avatars/').$currentPhoto;
            if (file_exists($userPhoto)) {
                @unlink($userPhoto);
            }
        }

        if ($request->password) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        $user->update($request->all());
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6'
        ]);

        if ($request->password) {
            $request->merge(['password' => Hash::make($request->password)]);
        }

        $user->update($request->all());

        $user_assignment = UserAssignment::where('user_id', $user->id)->first();
        if ($user_assignment != null) {
            $user_assignment->delete();
        }

        if ($request->role == 'Office User' || $request->role == 'Office Head') {
            UserAssignment::create([
                'user_id' => $user->id,
                'department_id' => $request->department_id
            ]);
        }

        return ['message' => 'User has been updated.'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdministrator');
        $user = User::findOrFail($id);
        $user->delete();

        return ['message' => 'User has been deleted.'];
    }
}
