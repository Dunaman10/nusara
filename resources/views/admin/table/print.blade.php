<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Print QR Code - {{ $table->name }}</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      margin: 0;
      padding: 0;
      background: #f4f4f4;
    }
    .print-container {
      background: #fff;
      width: 300px;
      margin: 50px auto;
      padding: 30px;
      border: 2px dashed #ccc;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .restaurant-name {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 5px;
      color: #333;
    }
    .table-name {
      font-size: 32px;
      font-weight: 900;
      color: #435ebe;
      margin: 10px 0 20px 0;
      border-bottom: 2px solid #eee;
      padding-bottom: 15px;
    }
    .qr-image {
      width: 250px;
      height: 250px;
      margin: 0 auto;
    }
    .instruction {
      margin-top: 20px;
      font-size: 14px;
      color: #666;
      line-height: 1.5;
    }
    .no-print {
      margin: 20px;
    }
    .btn {
      padding: 10px 20px;
      background: #435ebe;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      text-decoration: none;
      display: inline-block;
    }
    @media print {
      body {
        background: #fff;
      }
      .no-print {
        display: none;
      }
      .print-container {
        margin: 0;
        box-shadow: none;
        border: 2px solid #000;
      }
    }
  </style>
</head>
<body>

  <div class="no-print">
    <button class="btn" onclick="window.print()">
      🖨️ Cetak Sekarang
    </button>
    <a href="{{ route('tables.index') }}" class="btn" style="background:#dc3545; margin-left:10px;">
      Kembali
    </a>
  </div>

  <div class="print-container">
    <div class="restaurant-name">{{ $table->restaurant->name ?? 'Nusara' }}</div>
    <div class="table-name">{{ $table->name }}</div>
    
    @if($table->getQrCodeImageUrl())
      <img src="{{ $table->getQrCodeImageUrl() }}" class="qr-image" alt="QR Code">
    @else
      <div style="height: 250px; line-height: 250px; background: #eee; color: #999;">
        QR Code belum ada
      </div>
    @endif
    
    <div class="instruction">
      <strong>Scan untuk Pesan!</strong><br>
      Arahkan kamera HP Anda ke QR Code ini untuk melihat menu dan memesan.
    </div>
  </div>

  <script>
    // Automatis buka dialog print saat halaman dimuat (opsional)
    // window.onload = function() { window.print(); }
  </script>
</body>
</html>
