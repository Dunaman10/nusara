<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $categories = Category::all();

    return view('admin.category.index', compact('categories'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admin.category.create');
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
    ]);

    // Simpan data kategori ke database
    Category::create([
      'cat_name' => $request->cat_name,
      'description' => $request->description,
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

    return view('admin.category.edit', compact('category'));
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
    ]);

    // Temukan kategori yang akan diupdate
    $category = Category::findOrFail($id);

    // Update data kategori
    $category->update([
      'cat_name' => $request->cat_name,
      'description' => $request->description,
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
