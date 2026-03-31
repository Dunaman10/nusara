@extends('customer.layouts.master')

@section('content')
@php
    // Logic untuk mendeteksi apabila ada pesanan tunai (cash) yang masih ngendap (pending) di session
    $activeOrderCode = session('active_tunai_order');
    $activeOrder = null;
    if ($activeOrderCode) {
        $activeOrder = \App\Models\Order::where('order_code', $activeOrderCode)
            ->where('status', 'pending')
            ->where('payment_method', 'tunai')
            ->first();
        if (!$activeOrder) {
            session()->forget('active_tunai_order'); // Bersihkan jika sudah dibayar atau dibatalkan
        }
    }
@endphp
<style>
    /* Gradient hero background to ensure white text is always highly visible */
    .hero-bg-overlay {
        background: linear-gradient(rgba(33, 37, 41, 0.7), rgba(25, 135, 84, 0.85)), url('https://images.unsplash.com/photo-1543353071-873f17a7a088?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center center / cover no-repeat;
        padding-top: 80px;
        padding-bottom: 80px;
    }
    
    @media (max-width: 767px) {
        .hero-bg-overlay {
            padding-top: 60px;
            padding-bottom: 60px;
        }
    }
    
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.15)!important;
    }
    
    .img-zoom-wrapper {
        overflow: hidden;
    }
    .img-zoom-wrapper img {
        transition: transform 0.5s ease;
    }
    .hover-card:hover .img-zoom-wrapper img {
        transform: scale(1.1);
    }
    
    .category-badge-overlay {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
        backdrop-filter: blur(8px);
        background-color: rgba(255, 255, 255, 0.9);
        font-size: 0.7rem !important; /* Smaller for mobile */
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Search Bar Styling */
    .search-input-wrapper input:focus {
        box-shadow: none;
    }
    
    /* Responsive Headline */
    .hero-title {
        font-size: 2.2rem;
        text-shadow: 0 3px 5px rgba(0,0,0,0.5);
    }
    
    /* Floating Cart Button */
    .floating-cart {
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 1050;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(25, 135, 84, 0.4);
        transition: transform 0.3s ease;
    }
    .floating-cart:hover {
        transform: scale(1.1) translateY(-5px);
    }

    @media (min-width: 768px) {
        .hero-title {
            font-size: 4rem; /* Desktop size originally display-3 */
        }
        .category-badge-overlay {
            top: 15px;
            right: 15px;
            font-size: 0.9rem !important;
        }
    }
</style>

<!-- Sticky Pending Tunai Order Banner -->
@if($activeOrder)
<div class="bg-warning text-dark py-2 px-3 d-flex justify-content-between align-items-center shadow-sm" style="position: sticky; top: 0; z-index: 1055; width: 100%; border-bottom: 2px solid #e0a800;">
    <div class="d-flex align-items-center">
        <i class="fa fa-exclamation-circle text-danger me-2 fs-4"></i>
        <span class="fw-bold small lh-sm">Pesanan Tunai Aktif <br> <span class="fw-medium text-muted" style="font-size:0.75rem;">Kode: {{ $activeOrder->order_code }}</span></span>
    </div>
    <a href="{{ route('checkout.success', $activeOrder->order_code) }}" class="btn btn-dark btn-sm rounded-pill fw-bold shadow-sm px-3" style="white-space: nowrap;">
        Buka Struk <i class="fa fa-chevron-right ms-1"></i>
    </a>
</div>
@endif

<!-- Hero Section -->
<div class="container-fluid hero-bg-overlay mb-4 shadow">
  <div class="container text-center text-md-center px-3">
      <h1 class="text-white hero-title fw-bold mb-2">Temukan Rasamu</h1>
      <p class="text-white mb-0 px-md-5 mx-md-5 d-none d-md-block" style="opacity: 0.95; font-size: 1.1rem; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
          Penjelajahan rasa tiada akhir dengan koleksi hidangan terbaik yang disiapkan sepenuh hati oleh chef kami. Pesan sekarang dan nikmati kelezatannya!
      </p>
      <p class="text-white mb-0 d-md-none" style="opacity: 0.95; font-size: 0.9rem; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">
          Pesan sekarang dan nikmati sajian terbaik di Nusara!
      </p>
  </div>
</div>

<!-- Menu Section -->
<div class="container pb-5 px-3">

    <!-- Search & Filter Controls -->
    <div class="row justify-content-center mb-4 mx-0">
        <div class="col-12 col-md-8 col-lg-6 bg-white p-2 p-md-3 rounded-4 shadow-sm border border-light d-flex gap-2">
            <!-- Filter Dropdown Icon -->
            <div class="dropdown">
                <button class="btn btn-success rounded-circle shadow-sm d-flex align-items-center justify-content-center" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="width: 48px; height: 48px;" title="Filter Menu">
                    <i class="fa fa-filter fs-5"></i>
                </button>
                <ul class="dropdown-menu shadow border-0 rounded-4 mt-2 p-2" aria-labelledby="filterDropdown" id="filterOptions">
                    <li><button class="dropdown-item rounded-3 active filter-btn fw-bold" data-filter="all"><i class="fa fa-th-large me-2 text-muted"></i>Semua Menu</button></li>
                    <li><button class="dropdown-item rounded-3 filter-btn fw-bold" data-filter="Makanan"><i class="fa fa-utensils me-2 text-warning"></i>Makanan</button></li>
                    <li><button class="dropdown-item rounded-3 filter-btn fw-bold" data-filter="Minuman"><i class="fa fa-coffee me-2 text-info"></i>Minuman</button></li>
                </ul>
            </div>
            
            <!-- Search Bar -->
            <div class="input-group search-input-wrapper shadow-none rounded-pill overflow-hidden border border-success" style="border-width: 2px !important; flex-grow: 1;">
                <span class="input-group-text bg-white border-0 text-success ps-3 pe-2"><i class="fa fa-search"></i></span>
                <input type="text" id="searchInput" class="form-control border-0 bg-white px-0" placeholder="Cari menu..." aria-label="Search" style="font-size: 0.95rem;">
            </div>
        </div>
    </div>
    
    <!-- Render Data -->
    <div class="row g-3 g-md-4 justify-content-start" id="menuContainer">
        @forelse ($items as $item)
        <!-- class col-6 membuat tampilan tepat 2 kolom di HP -->
        <div class="col-6 col-md-4 col-lg-3 menu-item" 
             data-category="{{ $item->category->cat_name }}" 
             data-name="{{ strtolower($item->name) }}">
             
            <div class="card h-100 hover-card border-0 shadow-sm rounded-4">
                <div class="img-zoom-wrapper position-relative card-img-top rounded-top-4" style="aspect-ratio: 1/1; background-color: #f8f9fa;">
                    
                    <span class="badge category-badge-overlay text-dark border shadow-sm px-2 py-1 px-md-3 py-md-2 rounded-pill fw-bold">
                        <i class="fa @if($item->category->cat_name == 'Makanan') fa-utensils text-warning @elseif($item->category->cat_name == 'Minuman') fa-coffee text-info @else fa-star text-success @endif me-1 d-none d-md-inline-block"></i>
                        {{ $item->category->cat_name }}
                    </span>
                    
                    <img src="{{ asset('img_item_upload/'. $item->img) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $item->name }}" onerror="this.onerror=null;this.src='{{  $item->img }}';">
                </div>
                
                <div class="card-body d-flex flex-column p-2 p-md-3">
                    <h6 class="card-title fw-bold text-dark mb-1 lh-sm" style="font-size: 0.95rem;">{{ $item->name }}</h6>
                    <p class="card-text text-muted small line-clamp-2 d-none d-md-block mb-3" title="{{ $item->description }}">{{ $item->description }}</p>
                    
                    <div class="mt-auto d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center pt-2 gap-2">
                        <span class="fw-bolder text-success mb-0" style="font-size: 0.95rem;">{{ 'Rp '. number_format($item->price, 0, ',','.') }}</span>
                        <!-- Tombol Tambah Keranjang -->
                        <button onclick="addToCart({{ $item->id }}, this)" class="btn btn-success d-flex align-items-center justify-content-center rounded-circle shadow-sm align-self-end mt-1 mt-md-0 d-md-flex" style="width: 35px; height: 35px; min-width: 35px;" title="Tambah ke Keranjang">
                            <i class="fa fa-plus fs-6"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 my-5">
            <div class="p-4 p-md-5 rounded-4 bg-light shadow-sm">
                <i class="fa fa-folder-open mb-3 mb-md-4 text-success display-2 opacity-50"></i>
                <h4 class="text-success fw-bold">Belum Ada Menu</h4>
                <p class="text-muted fs-6 fs-md-5">Kami sedang menyiapkan sajian istimewa untuk Anda. Coba kembali lagi nanti!</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- State Kosong Pencarian -->
    <div class="row align-items-center justify-content-center d-none" id="emptySearch" style="min-height: 30vh;">
        <div class="col-12 col-md-8 text-center text-md-center">
            <div class="p-4 p-md-5 rounded-4 bg-white shadow-sm border border-light">
                <i class="fa fa-search mb-3 text-secondary display-4 opacity-25"></i>
                <h5 class="text-dark fw-bold mb-2">Menu Tidak Ditemukan</h5>
                <p class="text-muted small">Coba kata kunci atau ubah filter Anda.</p>
                <button class="btn btn-sm btn-outline-success rounded-pill px-4 mt-2" onclick="resetSearch()">Lihat Semua</button>
            </div>
        </div>
    </div>
</div>

@php
    $sessionCart = session('cart', []);
    $cartCount = is_array($sessionCart) ? array_sum(array_column($sessionCart, 'qty')) : 0;
@endphp
<!-- Floating Cart Button (Absolute/Fixed di kanan bawah) -->
<a href="{{ route('cart') }}" class="btn btn-success floating-cart text-white">
    <i class="fa fa-shopping-bag fs-4"></i>
    <span id="cartCounter" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger shadow-sm {{ $cartCount > 0 ? '' : 'd-none' }}" style="font-size: 0.75rem; padding: 0.35em 0.6em; border: 2px solid white;">
        {{ $cartCount }}
    </span>
</a>
@endsection

@section('script')
    <script>
        function resetSearch() {
            document.getElementById('searchInput').value = '';
            const allBtn = document.querySelector('[data-filter="all"]');
            if(allBtn) allBtn.click();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const filterBtns = document.querySelectorAll('.filter-btn');
            const menuItems = document.querySelectorAll('.menu-item');
            const emptySearchMessage = document.getElementById('emptySearch');
            let currentFilter = 'all';
            let currentSearch = '';

            searchInput.addEventListener('input', function(e) {
                currentSearch = e.target.value.toLowerCase().trim();
                applyFilterAndSearch();
            });

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Styling active dropdown item
                    filterBtns.forEach(b => {
                        b.classList.remove('active', 'bg-success', 'text-white');
                        b.classList.add('text-dark');
                    });
                    this.classList.add('active', 'bg-success', 'text-white');
                    this.classList.remove('text-dark');

                    currentFilter = this.getAttribute('data-filter');
                    applyFilterAndSearch();
                });
            });

            function applyFilterAndSearch() {
                let visibleCount = 0;

                menuItems.forEach(item => {
                    const itemName = item.getAttribute('data-name');
                    const itemCategory = item.getAttribute('data-category');
                    
                    const matchSearch = itemName.includes(currentSearch);
                    const matchFilter = currentFilter === 'all' || itemCategory === currentFilter;

                    if (matchSearch && matchFilter) {
                        if (item.style.display === 'none' || !item.hasAttribute('style')) {
                            item.style.display = 'block';
                            item.animate([
                                {opacity: 0, transform: 'scale(0.95)'}, 
                                {opacity: 1, transform: 'scale(1)'}
                            ], {duration: 250, fill: 'forwards'});
                        }
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (visibleCount === 0 && menuItems.length > 0) {
                    emptySearchMessage.classList.remove('d-none');
                } else {
                    emptySearchMessage.classList.add('d-none');
                }
            }
        });

        function addToCart(menuId, btnElement) {
            const originalHTML = btnElement.innerHTML;
            
            btnElement.innerHTML = '<i class="fa fa-spinner fa-spin fs-6"></i>';
            btnElement.disabled = true;
            btnElement.style.opacity = '0.7';

            fetch("{{ route('cart.add') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: menuId })
            })
            .then(response => response.json())
            .then(data => {
                btnElement.innerHTML = '<i class="fa fa-check fs-6 text-white"></i>';
                btnElement.classList.replace('btn-success', 'btn-dark');
                btnElement.style.opacity = '1';
                
                setTimeout(() => {
                    btnElement.innerHTML = originalHTML;
                    btnElement.classList.replace('btn-dark', 'btn-success');
                    btnElement.disabled = false;
                }, 1500);
                
                // Update Badge Counter
                const counterEl = document.getElementById('cartCounter');
                counterEl.classList.remove('d-none');
                let currentCount = parseInt(counterEl.innerText) || 0;
                
                // Add tiny bounce animation to badge
                counterEl.innerText = currentCount + 1;
                counterEl.animate([
                    {transform: 'translate(-50%, -50%) scale(1)'},
                    {transform: 'translate(-50%, -50%) scale(1.4)'},
                    {transform: 'translate(-50%, -50%) scale(1)'}
                ], {duration: 300, easing: 'ease-out'});
            })
            .catch((error) => {
                console.error('Error:', error);
                btnElement.innerHTML = originalHTML;
                btnElement.disabled = false;
                btnElement.style.opacity = '1';
                alert('Gagal memasukkan ke keranjang, coba lagi.');
            });
        }
    </script>
@endsection
