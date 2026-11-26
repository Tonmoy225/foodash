@extends('layouts.admin')
@section('page-title', 'Products')

@section('content')
<div class="page-actions">
    <a href="{{ route('admin.products.create') }}" class="btn-primary">+ Add Product</a>
</div>

<div class="admin-card">
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Stock</th><th>Available</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <img src="{{ $product->image_url }}" width="50" height="50"
                             style="border-radius:8px; object-fit:cover"
                             onerror="this.src='https://via.placeholder.com/50x50/e4002b/fff?text=F'">
                    </td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td>{{ $product->category->name }}</td>
                    <td>৳{{ number_format($product->price, 0) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <button class="toggle-btn {{ $product->is_available ? 'active' : '' }}"
                                data-id="{{ $product->id }}"
                                onclick="toggleProduct({{ $product->id }}, this)">
                            {{ $product->is_available ? 'Yes' : 'No' }}
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $products->links() }}
</div>
@endsection

@push('scripts')
<script>
function toggleProduct(id, btn) {
    fetch(`/admin/products/${id}/toggle`, {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content}
    })
    .then(r => r.json())
    .then(data => {
        btn.textContent = data.available ? 'Yes' : 'No';
        btn.className = 'toggle-btn ' + (data.available ? 'active' : '');
    });
}
</script>
@endpush
