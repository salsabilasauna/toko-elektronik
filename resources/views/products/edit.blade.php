@extends('layout')

@section('content')
    <div class="container mt-4">
        <h2>Edit Produk</h2>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('products.update', $product) }}" method="POST" class="mt-3">
            @csrf @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input 
                    type="text" 
                    class="form-control @error('name') is-invalid @enderror" 
                    id="name" 
                    name="name" 
                    value="{{ old('name', $product->name) }}"
                    placeholder="Masukkan nama produk"
                    required
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Produk</label>
                <textarea 
                    class="form-control @error('description') is-invalid @enderror" 
                    id="description" 
                    name="description" 
                    rows="3"
                    placeholder="Masukkan deskripsi produk"
                    required
                >{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="price" class="form-label">Harga Produk</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input 
                        type="number" 
                        class="form-control @error('price') is-invalid @enderror" 
                        id="price" 
                        name="price" 
                        value="{{ old('price', $product->price) }}"
                        placeholder="0"
                        min="0"
                        step="0.01"
                        required
                    >
                </div>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Masukkan harga dalam bentuk angka (contoh: 150000)</div>
            </div>
            
            <div class="mb-3">
                <label for="stock" class="form-label">Stok Produk</label>
                <input 
                    type="number" 
                    class="form-control @error('stock') is-invalid @enderror" 
                    id="stock" 
                    name="stock" 
                    value="{{ old('stock', $product->stock) }}"
                    placeholder="0"
                    min="1"
                    step="1"
                    required
                >
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Masukkan jumlah stok (bilangan bulat positif)</div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Edit Produk</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection
