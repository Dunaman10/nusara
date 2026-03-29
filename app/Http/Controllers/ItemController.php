<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $items = Item::orderBy('name', 'asc')->get();

    return view('admin.item.index', compact('items'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {

    $categories = Category::orderBy('cat_name', 'asc')->get();

    return view('admin.item.create', compact('categories'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    // Validate the request data
    $validatedData = $request->validate(
      [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'is_active' => 'required|boolean',
      ],
      [
        'name.required' => 'The item name is required',
        'description.string' => 'The description must be a string',
        'price.required' => 'The item price is required',
        'category_id.required' => 'The item category is required',
        'img.image' => 'The item image must be an image file',
        'img.max' => 'The item image must not exceed 2MB',
        'is_active.required' => 'The item status is required',
        'is_active.boolean' => 'The item status must be a true or false value',
      ],
    );

    // Handle image upload if provided
    if ($request->hasFile('img')) {
      $image = $request->file('img');
      $imageName = time() . '_' . $image->getClientOriginalName();
      $image->move(public_path('img_item_upload'), $imageName);
      $validatedData['img'] = $imageName;
    }

    // Create the item using the validated data
    Item::create($validatedData);

    // Redirect to the item index page with a success message
    return redirect()->route('items.index')->with('success', 'Item created successfully.');
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
    $item = Item::findOrFail($id);
    $categories = Category::orderBy('cat_name', 'asc')->get();

    return view('admin.item.edit', compact('item', 'categories'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    // Validate the request data
    $validatedData = $request->validate(
      [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'img' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        'is_active' => 'required|boolean',
      ],
      [
        'name.required' => 'The item name is required',
        'description.string' => 'The description must be a string',
        'price.required' => 'The item price is required',
        'category_id.required' => 'The item category is required',
        'img.image' => 'The item image must be an image file',
        'img.max' => 'The item image must not exceed 2MB',
        'is_active.required' => 'The item status is required',
        'is_active.boolean' => 'The item status must be a true or false value',
      ],
    );


    // Find the item by ID
    $item = Item::findOrFail($id);

    // Handle image upload if provided
    if ($request->hasFile('img')) {
      $image = $request->file('img');
      $imageName = time() . '_' . $image->getClientOriginalName();
      $image->move(public_path('img_item_upload'), $imageName);
      $validatedData['img'] = $imageName;
    }

    // Update the item with the validated data
    $item->update($validatedData);

    // Redirect to the item index page with a success message
    return redirect()->route('items.index')->with('success', 'Item updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    // Find the item by ID
    $item = Item::findOrFail($id);

    // Delete the item
    $item->delete();

    // Redirect to the item index page with a success message
    return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
  }

  public function updateStatus($id)
  {
    $item = Item::findOrFail($id);
    $item->is_active = !$item->is_active; // Toggle the status
    $item->save();

    return redirect()->route('items.index')->with('success', 'Item status updated successfully.');
  }
}
