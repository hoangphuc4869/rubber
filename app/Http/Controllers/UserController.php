<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all(); 
        $users = User::all(); 

        if (Gate::allows('admin')) {
            return view('users.create', compact('roles', 'users'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());
        // dd(in_array(17, $request->roles));
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
            'roles' => 'required|array', 
            'roles.*' => 'exists:roles,id',
        ]);

        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), 
        ]);

        if (in_array(17, $request->roles)) {  //17 is role customer in roles table
            $user->type = 1;
            $user->save();
        }

        $user->roles()->attach($request->roles);

        return redirect()->back()->with('success', 'Thêm người dùng thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $users = User::all(); 

        $roles = Role::all(); 

        if (Gate::allows('admin')) {
            return view('users.edit', compact('roles', 'users', 'user'));
        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }
    
        

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id, 
            'password' => 'nullable',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        
        $user = User::findOrFail($id);

       
        $user->name = $request->name;
        $user->email = $request->email;
        
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        $user->roles()->sync($request->roles);

        return redirect()->back()->with('success', 'Cập nhật người dùng thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Xóa thành công');
    }
}