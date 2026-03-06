<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MenuController extends Controller
{
  public function index(Request $request)
  {
    $tableNumber = $request->query('meja');
    if ($tableNumber) {
      Session::put('tableNumber', $tableNumber);
    }

    $items = Item::where('is_active', 1)->orderBy('name', 'asc')->get();

    return view('customer.menu', compact('items', 'tableNumber'));
  }

  // Cart
  public function cart()
  {
    $cart = Session::get('cart');
    return view('customer.cart', compact('cart'));
  }

  public function addToCart(Request $request)
  {
    $menuId = $request->input('id');
    $menu = Item::find($menuId);

    if (!$menu) {
      return response()->json([
        'status' => 'error',
        'message' => 'Menu tidak ditemukan'
      ]);
    }

    $cart = Session::get('cart', []);

    if (isset($cart[$menuId])) {
      $cart[$menuId]['qty'] += 1;
    } else {
      $cart[$menuId] = [
        'id' => $menu->id,
        'name' => $menu->name,
        'price' => $menu->price,
        'image' => $menu->img,
        'qty' => 1
      ];
    }

    Session::put('cart', $cart);

    return response()->json([
      'status' => 'success',
      'message' => 'Berhasil ditambahkan ke keranjang',
      'cart' => $cart
    ]);
  }

  public function updateCart(Request $request)
  {
    $menuId = $request->input('id');
    $change = $request->input('change');

    $cart = Session::get('cart', []);

    if (isset($cart[$menuId])) {
      $cart[$menuId]['qty'] += $change;

      if ($cart[$menuId]['qty'] <= 0) {
        unset($cart[$menuId]);
      }

      Session::put('cart', $cart);

      return response()->json([
        'status' => 'success',
        'message' => 'Keranjang berhasil diperbarui'
      ]);
    }

    return response()->json([
      'status' => 'error',
      'message' => 'Item tidak ditemukan di keranjang'
    ]);
  }

  public function removeFromCart(Request $request)
  {
    $menuId = $request->input('id');
    $cart = Session::get('cart', []);

    if (isset($cart[$menuId])) {
      unset($cart[$menuId]);
      Session::put('cart', $cart);

      return response()->json([
        'status' => 'success',
        'message' => 'Item berhasil dihapus dari keranjang'
      ]);
    }

    return response()->json([
      'status' => 'error',
      'message' => 'Item tidak ditemukan di keranjang'
    ]);
  }

  public function clearCart()
  {
    Session::forget('cart');
    return redirect()->route('cart')->with('success', 'Keranjang berhasil dikosongkan');
  }
}
