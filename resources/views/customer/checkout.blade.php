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
        .checkout-item-img {
            width: 50px !important;
            height: 50px !important;
        }
    }

    .checkout-item-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
    }

    /* Custom Radio Button Styling */
    .payment-radio input[type="radio"] {
        display: none;
    }
    .payment-radio label {
        display: flex;
        align-items: center;
        padding: 15px;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .payment-radio input[type="radio"]:checked + label {
        border-color: #198754;
        background-color: rgba(25, 135, 84, 0.05);
    }
    .payment-radio input[type="radio"]:checked + label .check-icon {
        color: #198754;
        opacity: 1;
    }
    .payment-radio .check-icon {
        opacity: 0;
        transition: opacity 0.3s ease;
    }
</style>

<!-- Hero Section -->
<div class="container-fluid hero-bg-overlay mb-5 shadow">
  <div class="container text-center px-3">
      <h1 class="text-white fw-bold mb-2 display-4" style="text-shadow: 0 4px 6px rgba(0,0,0,0.5);">Checkout</h1>
      <p class="text-white mb-0" style="opacity: 0.95; font-size: 1.1rem; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
          Silakan lengkapi detail dan selesaikan pesanan Anda.
      </p>
  </div>
</div>

<div class="container pb-5 px-3">
    <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row g-4 align-items-start">
            
            <!-- Kolom Kiri: Form & Daftar Pesanan -->
            <div class="col-lg-7 col-xl-8">
                
                <!-- Card Form Identitas -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom p-4 rounded-top-4">
                        <h5 class="fw-bold text-dark mb-0"><i class="fa fa-user-circle text-success me-2"></i>Detail Pemesan</h5>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small mb-1">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="fullname" class="form-control form-control-lg bg-light border-0 px-3" required placeholder="Masukkan nama Anda">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small mb-1">Nomor WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" name="phone" class="form-control form-control-lg bg-light border-0 px-3" required placeholder="Contoh: 08123456789">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold text-secondary small mb-1">Nomor Meja <span class="text-danger">*</span></label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-0 text-success"><i class="fa fa-chair"></i></span>
                                    <input type="text" value="{{ $tableNumber ?? 'Tidak Ada Nomor Meja' }}" class="form-control bg-light border-0 px-3 fw-bold text-dark" disabled required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold text-secondary small mb-1">Catatan Pesanan (Opsional)</label>
                                <textarea name="note" class="form-control bg-light border-0 p-3" spellcheck="false" rows="3" placeholder="Contoh: Jangan pakai seledri, pedas sedang, dll."></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Detail Pesanan -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-white border-bottom p-4 rounded-top-4">
                        <h5 class="fw-bold text-dark mb-0"><i class="fa fa-shopping-basket text-success me-2"></i>Pesanan Anda</h5>
                    </div>
                    <div class="card-body p-2 p-md-4">
                        @php
                            $subTotal = 0;
                        @endphp
                        
                        <div class="list-group list-group-flush">
                            @foreach (session('cart', []) as $item)
                            @php
                                $itemTotal = $item['price'] * $item['qty'];
                                $subTotal += $itemTotal;
                            @endphp
                            <div class="list-group-item d-flex align-items-center py-3 border-light bg-transparent">
                                <img src="{{ asset('img_item_upload/'. $item['image']) }}" class="rounded-circle checkout-item-img shadow-sm border border-light me-3" alt="{{ $item['name'] }}" onerror="this.onerror=null;this.src='{{ $item['image'] }}';">
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-1">{{ $item['name'] }}</h6>
                                    <p class="text-secondary small mb-0">{{ $item['qty'] }} x Rp{{ number_format($item['price'], 0, ',','.') }}</p>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold text-success">Rp{{ number_format($itemTotal, 0, ',','.') }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Rincian Tagihan & Metode Pembayaran -->
            <div class="col-lg-5 col-xl-4 position-sticky" style="top: 20px;">
                @php
                    $tax = $subTotal * 0.1;
                    $total = $subTotal + $tax;
                @endphp
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="fw-bold text-dark border-bottom pb-3 mb-4"><i class="fa fa-receipt text-success me-2"></i>Ringkasan Transaksi</h5>
                        
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

                        <!-- Opsi Pembayaran -->
                        <h6 class="fw-bold text-dark mb-3">Metode Pembayaran</h6>
                        <div class="d-flex flex-column gap-3 mb-4 payment-radio">
                            <div>
                                <input type="radio" id="qris" name="payment_method" value="qris">
                                <label for="qris" class="m-0 w-100 justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-qrcode text-secondary me-3 fs-5"></i>
                                        <span class="fw-semibold text-dark">QRIS</span>
                                    </div>
                                    <i class="fa fa-check-circle check-icon fs-5"></i>
                                </label>
                            </div>
                            <div>
                                <input type="radio" id="cash" name="payment_method" value="tunai">
                                <label for="cash" class="m-0 w-100 justify-content-between">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-money-bill-wave text-secondary me-3 fs-5"></i>
                                        <span class="fw-semibold text-dark">Tunai</span>
                                    </div>
                                    <i class="fa fa-check-circle check-icon fs-5"></i>
                                </label>
                            </div>
                        </div>

                        <button type="button" id="pay-button" class="btn btn-success btn-lg w-100 rounded-pill fw-bold shadow">
                            Konfirmasi Pesanan
                        </button>
                        <a href="/" class="btn btn-light btn-lg rounded-pill w-100 fw-bold shadow-sm mt-3 text-success border border-success border-opacity-25">
                            <i class="fa fa-arrow-left me-2"></i> Kembali ke Menu
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </form>
</div>

<!-- Scripts -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const payButton = document.getElementById("pay-button");
        const form = document.getElementById('checkout-form');

        payButton.addEventListener("click", function() {
            // Validasi Input dasar HTML
            if(!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let paymentMethod = document.querySelector('input[name="payment_method"]:checked');

            if(!paymentMethod){
                if(typeof Swal !== 'undefined') {
                    Swal.fire({icon: 'warning', title: 'Perhatian', text: 'Silakan pilih metode pembayaran terlebih dahulu!'});
                } else {
                    alert("Pilih metode pembayaran dulu!");
                }
                return;
            }

            paymentMethod = paymentMethod.value;
            let formData = new FormData(form);
            
            // UI Loading saat klik
            const originalText = payButton.innerHTML;
            payButton.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i> Memproses...';
            payButton.disabled = true;

            if(paymentMethod === 'tunai') {
                form.submit();
            } else {
                fetch("{{ route('checkout.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(data.snap_token) {
                        snap.pay(data.snap_token, {
                            onSuccess: function(result){
                                let url = "{{ route('checkout.success', ':orderId') }}";
                                window.location.href = url.replace(':orderId', data.order_code);
                            },
                            onPending: function(result){
                                payButton.innerHTML = originalText;
                                payButton.disabled = false;
                                if(typeof Swal !== 'undefined') {
                                    Swal.fire({icon: 'info', title: 'Menunggu', text: 'Selesaikan pembayaran pada popup Midtrans.'});
                                } else {
                                    alert("Menunggu Pembayaran");
                                }
                            },
                            onError: function(result){
                                payButton.innerHTML = originalText;
                                payButton.disabled = false;
                                if(typeof Swal !== 'undefined') {
                                    Swal.fire({icon: 'error', title: 'Gagal', text: 'Pembayaran Gagal dilakukan.'});
                                } else {
                                    alert('Pembayaran Gagal');
                                }
                            },
                            onClose: function(){
                                payButton.innerHTML = originalText;
                                payButton.disabled = false;
                            }
                        })
                    } else {
                        payButton.innerHTML = originalText;
                        payButton.disabled = false;
                        if(typeof Swal !== 'undefined') {
                            Swal.fire({icon: 'error', title: 'Oops', text: data.message || "Terjadi kesalahan sistem, silakan coba lagi."});
                        } else {
                            alert(data.message || "Terjadi kesalahan, silahkan coba lagi");
                        }
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    payButton.innerHTML = originalText;
                    payButton.disabled = false;
                    if(typeof Swal !== 'undefined') {
                        Swal.fire({icon: 'error', title: 'Error', text: 'Terjadi kesalahan pada sistem, silahkan coba lagi.'});
                    } else {
                        alert("Terjadi kesalahan pada sistem, silahkan coba lagi");
                    }
                })
            }
        });
    });
</script>
@endsection
