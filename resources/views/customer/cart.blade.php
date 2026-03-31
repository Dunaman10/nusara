@extends('customer.layouts.master')

@section('content')
<style>
    .hero-bg-overlay {
        background: linear-gradient(rgba(33, 37, 41, 0.8), rgba(25, 135, 84, 0.85)), url('https://images.unsplash.com/photo-1543353071-873f17a7a088?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center center / cover no-repeat;
        padding-top: 80px;
        padding-bottom: 80px;
    }
    
    @media (max-width: 767px) {
        .hero-bg-overlay {
            padding-top: 60px;
            padding-bottom: 60px;
        }
        .cart-item-img {
            width: 60px !important;
            height: 60px !important;
        }
        .quantity-control {
            max-width: 100px !important;
        }
    }
    
    .cart-item-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
    }
    
    .hover-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1) !important;
    }
</style>

<!-- Hero Section -->
<div class="container-fluid hero-bg-overlay mb-4 shadow">
  <div class="container text-center px-3">
      <h1 class="text-white fw-bold mb-2 display-4" style="text-shadow: 0 4px 6px rgba(0,0,0,0.5);">Keranjang Anda</h1>
      <p class="text-white mb-0" style="opacity: 0.95; font-size: 1.1rem; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
          Silahkan periksa kembali pesanan Anda sebelum melanjutkan.
      </p>
  </div>
</div>

<div class="container pb-5 px-3">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (empty($cart))
        <!-- State Kosong -->
        <div class="row align-items-center justify-content-center" style="min-height: 40vh;">
            <div class="col-12 col-md-8 text-center text-md-center">
                <div class="p-4 p-md-5 rounded-4 bg-white shadow-sm border border-light">
                    <i class="fa fa-shopping-basket mb-4 text-success display-2 opacity-50"></i>
                    <h4 class="text-dark fw-bold mb-3">Keranjang Masih Kosong</h4>
                    <p class="text-muted mb-4">Sepertinya Anda belum memilih menu apapun dari Nusara.</p>
                    <a href="/" class="btn btn-success rounded-pill px-4 py-2 shadow-sm fw-bold">
                        <i class="fa fa-utensils me-2"></i> Lihat Menu Kami
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row g-4 align-items-start">
            <!-- Kotak Kiri (Daftar Belanja) -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="fa fa-list-ul me-2 text-success"></i>Daftar Pesanan</h5>
                    <a href="{{ route('cart.clear') }}" class="btn btn-sm btn-outline-danger rounded-pill fw-bold" onclick="return confirm('Apakah Anda yakin ingin mengosongkan keseluruhan isi keranjang?')">
                        <i class="fa fa-trash-alt me-1"></i> Kosongkan
                    </a>
                </div>

                @php
                    $subTotal = 0;
                @endphp
                
                @foreach ($cart as $item)
                @php
                    $itemTotal = $item['price'] * $item['qty'];
                    $subTotal += $itemTotal;
                @endphp
                <div class="card border-0 shadow-sm rounded-4 mb-3 hover-card">
                    <div class="card-body p-3 p-md-4">
                        <div class="row align-items-center">
                            <!-- Image -->
                            <div class="col-3 col-sm-2 text-center pe-0">
                                <img src="{{ asset('img_item_upload/'. $item['image']) }}" class="rounded-circle cart-item-img shadow-sm border border-light" alt="{{ $item['name'] }}" onerror="this.onerror=null;this.src='{{  $item['image'] }}';">
                            </div>
                            
                            <!-- Name & Price (Mobile Stacked) -->
                            <div class="col-9 col-sm-4 ps-4 ps-sm-3">
                                <h6 class="fw-bold text-dark mb-1 lh-sm">{{ $item['name'] }}</h6>
                                <p class="text-secondary mb-0 small">Rp{{ number_format($item['price'], 0, ',','.') }}</p>
                            </div>
                            
                            <!-- Controls Form & Total Row For Mobile -->
                            <div class="col-12 col-sm-6 mt-3 mt-sm-0 pt-3 pt-sm-0 border-top border-sm-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    
                                    <!-- Plus Minus Button -->
                                    <div class="input-group quantity-control border border-success rounded-pill overflow-hidden shadow-sm" style="max-width: 120px;">
                                        <button class="btn btn-sm btn-light text-success fw-bold px-3 border-0 bg-white" type="button" onclick="updateQuantity('{{ $item['id'] }}', -1)">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <input id="qty-{{ $item['id'] }}" type="text" class="form-control form-control-sm text-center border-0 bg-white fw-bold px-0 text-dark" value="{{ $item['qty'] }}" readonly>
                                        <button class="btn btn-sm btn-light text-success fw-bold px-3 border-0 bg-white" type="button" onclick="updateQuantity('{{ $item['id'] }}', 1)">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="d-flex align-items-center gap-3">
                                        <!-- Subtotal Item -->
                                        <span class="fw-bolder text-success">Rp{{ number_format($itemTotal, 0, ',','.') }}</span>
                                        
                                        <!-- Hapus Button -->
                                        <button class="btn btn-sm btn-outline-danger rounded-circle shadow-sm d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;" onclick="if(confirm('Apakah anda yakin ingin menghapus pesanan {{ $item['name'] }}?')) { removeItemFromCart('{{ $item['id'] }}') }" title="Hapus Item">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Kotak Kanan (Ringkasan Pembayaran) -->
            <div class="col-lg-4">
                @php
                    $tax = $subTotal * 0.1;
                    $total = $subTotal + $tax;
                @endphp
                <div class="card border-0 shadow-sm rounded-4 position-sticky" style="top: 20px;">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold mb-4 text-dark border-bottom pb-3"><i class="fa fa-receipt me-2 text-success"></i>Ringkasan Transaksi</h5>
                        
                        <div class="d-flex justify-content-between mb-3 text-secondary">
                            <span>Subtotal</span>
                            <span class="fw-semibold text-dark">Rp{{ number_format($subTotal, 0, ',','.') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-4 text-secondary">
                            <span>Pajak (10%)</span>
                            <span class="fw-semibold text-dark">Rp{{ number_format($tax, 0, ',','.') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center py-3 border-top border-bottom mb-4">
                            <h5 class="mb-0 fw-bold text-dark">Total</h5>
                            <h4 class="mb-0 fw-black text-success">Rp{{ number_format($total, 0, ',','.') }}</h4>
                        </div>
                        
                        <a href="{{ route('checkout') }}" class="btn btn-success btn-lg rounded-pill w-100 fw-bold shadow">
                            <i class="fa fa-credit-card me-2"></i> Lanjut Pembayaran
                        </a>
                        <a href="/" class="btn btn-light btn-lg rounded-pill w-100 fw-bold shadow-sm mt-3 text-success border border-success border-opacity-25">
                            <i class="fa fa-arrow-left me-2"></i> Tambah Menu Lain
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('script')
<script>
    // Optimasi fungsi interaksi untuk UX Loading
    function updateQuantity(menuId, change) {
        // Overlay transparant pencegah spam click saat internet lemot
        const overlay = document.createElement('div');
        overlay.innerHTML = '<div class="spinner-border text-success" role="status"></div>';
        overlay.className = 'position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-white bg-opacity-50';
        overlay.style.zIndex = '9999';
        document.body.appendChild(overlay);

        fetch("{{ route('cart.update') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: menuId, change: change })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                location.reload();
            } else {
                overlay.remove();
                if(typeof Swal !== 'undefined') {
                    Swal.fire({icon: 'error', title: 'Ups!', text: data.message});
                } else {
                    alert(data.message);
                }
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            overlay.remove();
        });
    }

    function removeItemFromCart(menuId) {
        const overlay = document.createElement('div');
        overlay.innerHTML = '<div class="spinner-border text-danger" role="status"></div>';
        overlay.className = 'position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-white bg-opacity-50';
        overlay.style.zIndex = '9999';
        document.body.appendChild(overlay);

        fetch("{{ route('cart.remove') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id: menuId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                location.reload();
            } else {
                overlay.remove();
                if(typeof Swal !== 'undefined') {
                    Swal.fire({icon: 'error', title: 'Ups!', text: data.message});
                } else {
                    alert(data.message);
                }
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            overlay.remove();
        });
    }
</script>
@endsection
