<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Table extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'restaurant_id',
    'qr_code_url',
    'qr_code_path',
    'is_active',
  ];

  protected $casts = [
    'is_active' => 'boolean',
  ];

  /**
   * Relasi ke Restaurant
   */
  public function restaurant()
  {
    return $this->belongsTo(Restaurant::class);
  }

  /**
   * Relasi ke Order (via table_number atau table_id)
   */
  public function orders()
  {
    return $this->hasMany(Order::class, 'table_number', 'id');
  }

  /**
   * Generate URL unik untuk QR Code meja ini
   */
  public function generateQrUrl(): string
  {
    $baseUrl = config('app.url');
    return "{$baseUrl}/menu?table={$this->id}&restaurant={$this->restaurant_id}";
  }

  /**
   * Generate dan simpan QR Code sebagai file SVG
   * Mengembalikan path file yang disimpan
   */
  public function generateAndSaveQrCode(): string
  {
    $url = $this->generateQrUrl();

    // Buat direktori jika belum ada
    $directory = "qrcodes/restaurant_{$this->restaurant_id}";
    Storage::disk('public')->makeDirectory($directory);

    $filename = "{$directory}/table_{$this->id}.svg";

    // Generate QR code sebagai SVG dan simpan ke storage
    $qrImage = QrCode::format('svg')
      ->size(300)
      ->margin(2)
      ->errorCorrection('H')
      ->generate($url);

    Storage::disk('public')->put($filename, $qrImage);

    return $filename;
  }

  /**
   * Mendapatkan URL publik dari gambar QR Code
   */
  public function getQrCodeImageUrl(): ?string
  {
    if ($this->qr_code_path && Storage::disk('public')->exists($this->qr_code_path)) {
      return Storage::disk('public')->url($this->qr_code_path);
    }
    return null;
  }
}
