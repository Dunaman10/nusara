<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $users = User::whereHas('role', function ($query) {
      $query->where('role_name', '!=', 'customer');
    })->orderBy('fullname')->get();
    return view('admin.user.index', compact('users'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $users = User::all();
    $roles = Role::where('role_name', '!=', 'customer')->get();

    return view('admin.user.create', compact('users', 'roles'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // Validate the request data
    $request->validate([
      'username' => 'required|unique:users,username',
      'fullname' => 'required',
      'email' => 'required|email|unique:users,email',
      'phone' => 'required|unique:users,phone',
      'role_id' => 'required|exists:roles,id',
      'password' => 'required|confirmed|min:6',
    ]);

    // Create a new user
    User::create([
      'username' => $request->username,
      'fullname' => $request->fullname,
      'email' => $request->email,
      'phone' => $request->phone,
      'role_id' => $request->role_id,
      'password' => bcrypt($request->password),
    ]);

    // Redirect to the user index page with a success message
    return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
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
    $roles = Role::all();

    return view('admin.user.edit', compact('user', 'roles'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $request->validate([
      'username' => 'required|unique:users,username,' . $id,
      'fullname' => 'required',
      'email' => 'required|email|unique:users,email,' . $id,
      'phone' => 'required|unique:users,phone,' . $id,
      'role_id' => 'required|exists:roles,id',
      'password' => 'nullable|confirmed|min:6',
    ]);

    $user = User::findOrFail($id);
    $data = [
      'username' => $request->username,
      'fullname' => $request->fullname,
      'email' => $request->email,
      'phone' => $request->phone,
      'role_id' => $request->role_id,
    ];

    if ($request->filled('password')) {
      $data['password'] = bcrypt($request->password);
    }

    $user->update($data);

    return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
  }
}
