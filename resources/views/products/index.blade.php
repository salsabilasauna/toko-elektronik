@extends('layout')

@section('content')
    <h1 class="text-center mb-3">Toko Elektronik</h1>
    <div class="d-flex justify-content-end mb-3 align-items-center">
        <form action="{{ route('products.index') }}" method="GET" class="d-flex me-2" id="search-form">
            <input class="form-control me-1" type="search" name="search" placeholder="Cari Produk..."
                value="{{ request('search') }}" id="search-input">
        </form>
        <a href="{{ route('products.create') }}" class="btn btn-primary me-2">+ Tambah Produk</a>
        <a href="{{ route('products.pdf') }}" class="btn btn-success me-2">Export PDF</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                @php
                    $queryParams = ['search' => request('search')];
                    $sortLink = function ($sortByColumn, $direction) use ($queryParams) {
                        return route(
                            'products.index',
                            array_merge($queryParams, ['sort_by' => $sortByColumn, 'sort_direction' => $direction]),
                        );
                    };
                    $activeClass = function ($sortByColumn, $direction) use ($sortBy, $sortDirection) {
                        return $sortBy === $sortByColumn && $sortDirection === $direction ? 'fw-bold text-warning' : '';
                    };
                @endphp
                <th class="text-center">
                    Nama Produk
                    <a href="{{ $sortLink('name', 'asc') }}"
                        class="text-white text-decoration-none {{ $activeClass('name', 'asc') }}">&#9650;</a>
                    <a href="{{ $sortLink('name', 'desc') }}"
                        class="text-white text-decoration-none {{ $activeClass('name', 'desc') }}">&#9660;</a>
                </th>
                <th class="text-center">
                    Deskripsi
                    <a href="{{ $sortLink('description', 'asc') }}"
                        class="text-white text-decoration-none {{ $activeClass('description', 'asc') }}">&#9650;</a>
                    <a href="{{ $sortLink('description', 'desc') }}"
                        class="text-white text-decoration-none {{ $activeClass('description', 'desc') }}">&#9660;</a>
                </th>
                <th class="text-center">
                    Harga
                    <a href="{{ $sortLink('price', 'asc') }}"
                        class="text-white text-decoration-none {{ $activeClass('price', 'asc') }}">&#9650;</a>
                    <a href="{{ $sortLink('price', 'desc') }}"
                        class="text-white text-decoration-none {{ $activeClass('price', 'desc') }}">&#9660;</a>
                </th>
                <th class="text-center">
                    Stok
                    <a href="{{ $sortLink('stock', 'asc') }}"
                        class="text-white text-decoration-none {{ $activeClass('stock', 'asc') }}">&#9650;</a>
                    <a href="{{ $sortLink('stock', 'desc') }}"
                        class="text-white text-decoration-none {{ $activeClass('stock', 'desc') }}">&#9660;</a>
                </th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td class="text-center">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $products->appends(request()->query())->links() }}
    </div>

    <script>
        const searchForm = document.getElementById('search-form');
        const searchInput = document.getElementById('search-input');
        let typingTimer;
        const doneTypingInterval = 500; // 500ms

        searchInput.addEventListener('input', () => {
            clearTimeout(typingTimer);

            typingTimer = setTimeout(() => {
                const currentQuery = new URLSearchParams(window.location.search);

                if (searchInput.value.trim() === '') {
                    // Redirect to clean index page only if there was a search query before
                    if (currentQuery.get('search')) {
                        window.location.href = '{{ route('products.index') }}';
                    }
                } else {
                    searchForm.submit();
                }
            }, doneTypingInterval);
        });
    </script>
@endsection
