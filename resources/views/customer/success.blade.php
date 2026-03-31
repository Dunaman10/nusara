@extends('customer.layouts.master')

@section('title', 'Pesanan Terekam')

@section('content')
<style>
    /* Gradient hero background to ensure white text is always highly visible */
    .receipt-hero-overlay {
        background: linear-gradient(rgba(33, 37, 41, 0.8), rgba(25, 135, 84, 0.9)), url('https://images.unsplash.com/photo-1543353071-873f17a7a088?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center center / cover no-repeat;
        padding-top: 80px;
        padding-bottom: 120px; /* Ekstra ruang bawah untuk overlap kartunya */
    }
    
    @media (max-width: 767px) {
        .receipt-hero-overlay {
            padding-top: 50px;
            padding-bottom: 90px;
        }
    }

    .receipt-card {
        margin-top: -80px; /* Offset to make it float over the hero background */
        max-width: 500px;
        border-top: 8px solid #198754;
    }

    .dashed-divider {
        border-top: 2px dashed #dee2e6;
        margin: 1.5rem 0;
    }
</style>

<!-- Hero Section -->
<div class="container-fluid receipt-hero-overlay shadow">
  <div class="container text-center px-3">
      <h1 class="text-white fw-bold mb-2 display-5" style="text-shadow: 0 4px 6px rgba(0,0,0,0.5);">Detail Pesanan Anda</h1>
  </div>
</div>

<!-- Receipt Content -->
<div class="container pb-5 px-3">
    <div class="row justify-content-center">
        <div class="col-12 w-100 d-flex justify-content-center">
            
            <div class="card bg-white border-0 shadow-lg rounded-4 receipt-card w-100">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Header Nota -->
                    <div class="text-center mb-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success rounded-circle mb-3 shadow-sm" style="width: 70px; height: 70px;">
                            <i class="fas fa-check text-white fs-1"></i>
                        </div>
                        <h4 class="fw-bold text-dark">Pesanan Berhasil Dicatat</h4>
                        
                        <div class="mt-3">
                            @if($order->payment_method == 'tunai' && $order->status == 'pending')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold"><i class="fa fa-clock me-1"></i> Menunggu Pembayaran Tunai</span>
                            @elseif($order->payment_method == 'qris' && $order->status == 'pending')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold"><i class="fa fa-qrcode me-1"></i> Menunggu Konfirmasi QRIS</span>
                            @else
                                <span class="badge bg-success px-3 py-2 rounded-pill fw-semibold"><i class="fa fa-check-circle me-1"></i> Pembayaran Lunas</span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-light rounded-4 p-4 text-center mb-4 border" style="border-color: #28a745 !important;">
                        <p class="text-muted mb-1 small text-uppercase fw-bold letter-spacing-1">Kode Pesanan</p>
                        <h2 class="fw-black text-success mb-0 tracking-wide" style="letter-spacing: 2px;">{{ $order->order_code }}</h2>
                    </div>

                    <!-- Detail List -->
                    <h6 class="fw-bold text-dark mb-3"><i class="fa fa-list-ul text-success me-2"></i>Rincian Tagihan</h6>
                    
                    <ul class="list-group list-group-flush mb-3">
                        @foreach ($orderItems as $orderItem)
                        <li class="list-group-item d-flex justify-content-between align-items-start px-0 border-light py-2 bg-transparent">
                            <div class="me-auto">
                                <span class="fw-semibold text-dark">{{ Str::limit($orderItem->item->name, 25) }}</span>
                                <small class="text-muted d-block">{{ $orderItem->quantity }}x Item</small>
                            </div>
                            <span class="text-dark fw-medium">Rp{{ number_format($orderItem->price, 0, ',', '.') }}</span>
                        </li>
                        @endforeach
                    </ul>
                    
                    <div class="dashed-divider"></div>

                    <!-- Summary -->
                    <div class="d-flex justify-content-between mb-2 text-muted fw-medium">
                        <span>Subtotal</span>
                        <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-muted fw-medium">
                        <span>Pajak (10%)</span>
                        <span>Rp{{ number_format($order->tax, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded-3 mb-4 mt-2 border shadow-sm" style="background-color: #f8f9fa; border-color: #28a745 !important;">
                        <h5 class="mb-0 fw-bold text-dark">Total Akhir</h5>
                        <h4 class="mb-0 fw-bolder" style="color: #198754;">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</h4>
                    </div>

                    <!-- Instructions / Footer Info -->
                    <div class="text-center mt-4">
                        @if($order->status == 'pending')
                            <p class="small text-muted mb-0"><i class="fa fa-info-circle me-1"></i> Silakan tunjukkan kode bayar pesanan ini kepada kasir kami untuk konfirmasi dan penyelesaian pembayaran.</p>
                        @else
                            <p class="small text-success fw-medium mb-0"><i class="fa fa-utensils me-1"></i> Yeay, transaksi tervalidasi! Silakan duduk manis, makanan lezat Anda sedang disiapkan.</p>
                        @endif
                    </div>

                    <div class="dashed-divider"></div>

                    <!-- Action Button -->
                    <a href="/" class="btn btn-success btn-lg rounded-pill w-100 fw-bold shadow-sm d-flex justify-content-center align-items-center">
                        <i class="fa fa-arrow-left me-2"></i> Kembali ke Menu Utama
                    </a>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection
