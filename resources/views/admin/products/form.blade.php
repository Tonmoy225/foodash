@extends('layouts.admin')
@section('page-title', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')
<div class="admin-card" style="max-width:700px">
    <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($product)) @method('PUT') @endif

        <div class="form-grid">
            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Category *</label>
                <select name="category_id" required>
                    <option value="">Select category</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ (old('category_id', $product->category_id ?? '') == $cat->id) ? 'selected' : '' }}>
                        {{ $cat->icon }} {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Price (৳) *</label>
                <input type="number" name="price" step="0.01" value="{{ old('price', $product->price ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Stock *</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 100) }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3">{{ old('description', $product->description ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label>Product Image</label>
            <input type="file" name="image" accept="image/*" onchange="previewImg(this)">
            @if(isset($product) && $product->image)
            <img id="imgPreview" src="{{ $product->image_url }}" style="width:120px;height:80px;object-fit:cover;border-radius:8px;margin-top:8px">
            @else
            <img id="imgPreview" src="" style="display:none;width:120px;height:80px;object-fit:cover;border-radius:8px;margin-top:8px">
            @endif
        </div>

        <div class="form-group">
            <label class="checkbox-label">
                <input type="checkbox" name="is_available" value="1" {{ (old('is_available', $product->is_available ?? 1)) ? 'checked' : '' }}>
                Available for order
            </label>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.products.index') }}" class="btn-outline">Cancel</a>
            <button type="submit" class="btn-primary">{{ isset($product) ? 'Update Product' : 'Add Product' }}</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewImg(input) {
    const preview = document.getElementById('imgPreview');
    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        preview.style.display = 'block';
    }
}
</script>
@endpush
