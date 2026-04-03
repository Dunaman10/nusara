<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TableController extends Controller
{
  /**
   * Tampilkan daftar semua meja
   */
  public function index()
  {
    $restaurants = Restaurant::where('is_active', true)->get();

    $query = Table::with('restaurant');

    if (auth()->user()->role->role_name !== 'super_admin') {
      $query->where('restaurant_id', auth()->user()->restaurant_id);
    } else {
      $query->when(request('restaurant_id'), function ($q) {
        $q->where('restaurant_id', request('restaurant_id'));
      });
    }

    $tables = $query->orderBy('restaurant_id')->orderBy('name')->get();

    return view('admin.table.index', compact('tables', 'restaurants'));
  }

  /**
   * Form tambah meja baru
   */
  public function create()
  {
    $restaurants = Restaurant::where('is_active', true)->get();
    return view('admin.table.create', compact('restaurants'));
  }

  /**
   * Simpan meja baru dan generate QR Code
   */
  public function store(Request $request)
  {
    $request->validate([
      'name'          => 'required|string|max:100',
      'restaurant_id' => 'required|exists:restaurants,id',
    ]);

    $validatedData['name'] = $request->name;
    $validatedData['is_active'] = $request->boolean('is_active', true);

    if (auth()->user()->role->role_name !== 'super_admin') {
      $validatedData['restaurant_id'] = auth()->user()->restaurant_id;
    } else {
      $validatedData['restaurant_id'] = $request->restaurant_id;
    }

    // Simpan meja dahulu untuk mendapatkan ID
    $table = Table::create($validatedData);

    // Generate URL QR code
    $qrUrl = $table->generateQrUrl();

    // Generate dan simpan gambar QR code
    $qrPath = $table->generateAndSaveQrCode();

    // Update meja dengan URL dan path QR code
    $table->update([
      'qr_code_url'  => $qrUrl,
      'qr_code_path' => $qrPath,
    ]);

    return redirect()->route('tables.index')
      ->with('success', "Meja \"{$table->name}\" berhasil dibuat beserta QR Code-nya.");
  }

  /**
   * Tampilkan detail meja + QR Code
   */
  public function show(Table $table)
  {
    if (auth()->user()->role->role_name !== 'super_admin' && $table->restaurant_id !== auth()->user()->restaurant_id) {
      abort(403, 'Unauthorized action.');
    }

    $table->load('restaurant');
    return view('admin.table.show', compact('table'));
  }

  /**
   * Form edit meja
   */
  public function edit(Table $table)
  {
    if (auth()->user()->role->role_name !== 'super_admin' && $table->restaurant_id !== auth()->user()->restaurant_id) {
      abort(403, 'Unauthorized action.');
    }

    $restaurants = Restaurant::where('is_active', true)->get();
    return view('admin.table.edit', compact('table', 'restaurants'));
  }

  /**
   * Update data meja
   */
  public function update(Request $request, Table $table)
  {
    $request->validate([
      'name'          => 'required|string|max:100',
      'restaurant_id' => 'required|exists:restaurants,id',
    ]);

    if (auth()->user()->role->role_name !== 'super_admin' && $table->restaurant_id !== auth()->user()->restaurant_id) {
      abort(403, 'Unauthorized action.');
    }

    $updateData = [
      'name'          => $request->name,
      'is_active'     => $request->boolean('is_active', true),
    ];

    if (auth()->user()->role->role_name !== 'super_admin') {
      $updateData['restaurant_id'] = auth()->user()->restaurant_id;
    } else {
      $updateData['restaurant_id'] = $request->restaurant_id;
    }

    $table->update($updateData);

    // Regenerate QR code jika nama atau restaurant berubah
    $newQrUrl = $table->generateQrUrl();
    if ($table->qr_code_url !== $newQrUrl || !$table->getQrCodeImageUrl()) {
      // Hapus QR lama
      if ($table->qr_code_path) {
        Storage::disk('public')->delete($table->qr_code_path);
      }
      // Generate yang baru
      $qrPath = $table->generateAndSaveQrCode();
      $table->update([
        'qr_code_url'  => $newQrUrl,
        'qr_code_path' => $qrPath,
      ]);
    }

    return redirect()->route('tables.index')
      ->with('success', "Meja \"{$table->name}\" berhasil diperbarui.");
  }

  /**
   * Hapus meja dan QR Code-nya
   */
  public function destroy(Table $table)
  {
    if (auth()->user()->role->role_name !== 'super_admin' && $table->restaurant_id !== auth()->user()->restaurant_id) {
      abort(403, 'Unauthorized action.');
    }

    // Hapus file QR code jika ada
    if ($table->qr_code_path) {
      Storage::disk('public')->delete($table->qr_code_path);
    }

    $name = $table->name;
    $table->delete();

    return redirect()->route('tables.index')
      ->with('success', "Meja \"{$name}\" berhasil dihapus.");
  }

  /**
   * Regenerate QR code untuk meja tertentu
   */
  public function regenerateQr(Table $table)
  {
    if (auth()->user()->role->role_name !== 'super_admin' && $table->restaurant_id !== auth()->user()->restaurant_id) {
      abort(403, 'Unauthorized action.');
    }

    // Hapus QR lama
    if ($table->qr_code_path) {
      Storage::disk('public')->delete($table->qr_code_path);
    }

    // Generate baru
    $qrUrl  = $table->generateQrUrl();
    $qrPath = $table->generateAndSaveQrCode();

    $table->update([
      'qr_code_url'  => $qrUrl,
      'qr_code_path' => $qrPath,
    ]);

    return redirect()->back()
      ->with('success', "QR Code meja \"{$table->name}\" berhasil di-regenerate.");
  }

  /**
   * Download QR code sebagai file SVG
   */
  public function downloadQr(Table $table)
  {
    if (auth()->user()->role->role_name !== 'super_admin' && $table->restaurant_id !== auth()->user()->restaurant_id) {
      abort(403, 'Unauthorized action.');
    }

    if (!$table->qr_code_path || !Storage::disk('public')->exists($table->qr_code_path)) {
      return redirect()->back()->with('error', 'QR Code tidak ditemukan. Coba regenerate.');
    }

    $filename = "qrcode-meja-{$table->name}-{$table->restaurant->name}.svg";
    return Storage::disk('public')->download($table->qr_code_path, $filename);
  }

  public function printQr(Table $table)
  {
    if (auth()->user()->role->role_name !== 'super_admin' && $table->restaurant_id !== auth()->user()->restaurant_id) {
      abort(403, 'Unauthorized action.');
    }

    $table->load('restaurant');
    return view('admin.table.print', compact('table'));
  }
}
