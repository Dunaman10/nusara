<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $roles = Role::all();
    return view('admin.role.index', compact('roles'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.role.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // Validate the request data
    $request->validate([
      'role_name' => 'required|string|max:255',
      'description' => 'required|string',
    ]);

    // Create the role
    Role::create($request->all());

    // Redirect to the index page with a success message
    return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan.');
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
    return view('admin.role.edit', [
      'role' => Role::findOrFail($id)
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $request->validate([
      'role_name' => 'required|string|max:255',
      'description' => 'required|string',
    ]);

    $role = Role::findOrFail($id);
    $role->update($request->all());

    return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $role = Role::findOrFail($id);
    $role->delete();

    return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
  }
}
