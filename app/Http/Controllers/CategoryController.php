<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $categories = Category::with('restaurant')->orderBy('cat_name')->get();

    return view('admin.category.index', compact('categories'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $restaurants = Restaurant::where('is_active', 1)->get();
    return view('admin.category.create', compact('restaurants'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // Validasi input
    $request->validate([
      'cat_name' => 'required|string|max:255',
      'description' => 'required|string',
      'restaurant_id' => 'required|exists:restaurants,id',
    ]);

    // Simpan data kategori ke database
    Category::create([
      'cat_name' => $request->cat_name,
      'description' => $request->description,
      'restaurant_id' => $request->restaurant_id,
    ]);

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
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
    $category = Category::findOrFail($id);
    $restaurants = Restaurant::where('is_active', 1)->get();

    return view('admin.category.edit', compact('category', 'restaurants'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    // Validasi input
    $request->validate([
      'cat_name' => 'required|string|max:255',
      'description' => 'required|string',
      'restaurant_id' => 'required|exists:restaurants,id',
    ]);

    // Temukan kategori yang akan diupdate
    $category = Category::findOrFail($id);

    // Update data kategori
    $category->update([
      'cat_name' => $request->cat_name,
      'description' => $request->description,
      'restaurant_id' => $request->restaurant_id,
    ]);

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    // Temukan kategori yang akan dihapus
    $category = Category::findOrFail($id);

    // Hapus kategori
    $category->delete();

    // Redirect ke halaman index dengan pesan sukses
    return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
  }
}
