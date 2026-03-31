<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $restaurants = Restaurant::all();
    return view('admin.restaurant.index', compact('restaurants'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.restaurant.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'slug' => 'required|string|max:255|unique:restaurants,slug',
      'address' => 'nullable|string',
      'phone' => 'nullable|string',
      'email' => 'nullable|email',
    ]);

    Restaurant::create([
      'name' => $request->name,
      'slug' => $request->slug,
      'address' => $request->address,
      'phone' => $request->phone,
      'email' => $request->email,
      'is_active' => $request->boolean('is_active', true),
    ]);

    return redirect()->route('restaurants.index')->with('success', 'Restoran berhasil ditambahkan.');
  }

  /**
   * Display the specified resource.
   */
  public function show(Restaurant $restaurant)
  {
    return view('admin.restaurant.show', compact('restaurant'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Restaurant $restaurant)
  {
    return view('admin.restaurant.edit', compact('restaurant'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Restaurant $restaurant)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'slug' => 'required|string|max:255|unique:restaurants,slug,' . $restaurant->id,
      'address' => 'nullable|string',
      'phone' => 'nullable|string',
      'email' => 'nullable|email',
    ]);

    $restaurant->update([
      'name' => $request->name,
      'slug' => $request->slug,
      'address' => $request->address,
      'phone' => $request->phone,
      'email' => $request->email,
      'is_active' => $request->boolean('is_active', true),
    ]);

    return redirect()->route('restaurants.index')->with('success', 'Restoran berhasil diperbarui.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Restaurant $restaurant)
  {
    $name = $restaurant->name;
    $restaurant->delete();

    return redirect()->route('restaurants.index')->with('success', "Restoran \"{$name}\" berhasil dihapus.");
  }
}
