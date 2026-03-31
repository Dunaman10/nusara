<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $query = User::with('restaurant')->whereHas('role', function ($query) {
      $query->where('role_name', '!=', 'customer');
    });
    
    if (auth()->user()->role->role_name !== 'super_admin') {
      $query->where('restaurant_id', auth()->user()->restaurant_id);
    }

    $users = $query->orderBy('fullname')->get();
    return view('admin.user.index', compact('users'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $users = User::all();
    $roles = Role::where('role_name', '!=', 'customer');
    
    // Admin cannot create super_admins
    if (auth()->user()->role->role_name !== 'super_admin') {
      $roles->where('role_name', '!=', 'super_admin');
    }
    
    $roles = $roles->get();
    $restaurants = Restaurant::where('is_active', 1)->get();

    return view('admin.user.create', compact('users', 'roles', 'restaurants'));
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
      'restaurant_id' => auth()->user()->role->role_name === 'super_admin' ? 'required|exists:restaurants,id' : 'nullable',
    ]);

    // Create a new user
    User::create([
      'username' => $request->username,
      'fullname' => $request->fullname,
      'email' => $request->email,
      'phone' => $request->phone,
      'role_id' => $request->role_id,
      'password' => bcrypt($request->password),
      'restaurant_id' => auth()->user()->role->role_name === 'super_admin' ? $request->restaurant_id : auth()->user()->restaurant_id,
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
    
    // Prevent unauthorized access
    if (auth()->user()->role->role_name !== 'super_admin' && $user->restaurant_id !== auth()->user()->restaurant_id) {
       abort(403, 'Unauthorized action.');
    }
    
    $roles = Role::where('role_name', '!=', 'customer');
    if (auth()->user()->role->role_name !== 'super_admin') {
      $roles->where('role_name', '!=', 'super_admin');
    }
    $roles = $roles->get();
    
    $restaurants = Restaurant::where('is_active', 1)->get();

    return view('admin.user.edit', compact('user', 'roles', 'restaurants'));
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
      'restaurant_id' => auth()->user()->role->role_name === 'super_admin' ? 'required|exists:restaurants,id' : 'nullable',
    ]);

    $user = User::findOrFail($id);
    
    // Prevent unauthorized access
    if (auth()->user()->role->role_name !== 'super_admin' && $user->restaurant_id !== auth()->user()->restaurant_id) {
       abort(403, 'Unauthorized action.');
    }
    
    $data = [
      'username' => $request->username,
      'fullname' => $request->fullname,
      'email' => $request->email,
      'phone' => $request->phone,
      'role_id' => $request->role_id,
      'restaurant_id' => auth()->user()->role->role_name === 'super_admin' ? $request->restaurant_id : auth()->user()->restaurant_id,
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
    
    // Prevent unauthorized access
    if (auth()->user()->role->role_name !== 'super_admin' && $user->restaurant_id !== auth()->user()->restaurant_id) {
       abort(403, 'Unauthorized action.');
    }
    
    $user->delete();

    return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
  }
}
