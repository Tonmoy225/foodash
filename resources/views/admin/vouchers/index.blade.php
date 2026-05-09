@extends('layouts.admin')
@section('page-title', 'Vouchers')

@section('content')
<div class="page-actions">
    <a href="{{ route('admin.vouchers.create') }}" class="btn-primary">+ Add Voucher</a>
</div>

<div class="admin-card">
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>Code</th><th>Type</th><th>Value</th><th>Min Order</th><th>Uses</th><th>Expires</th><th>Active</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @foreach($vouchers as $v)
                <tr>
                    <td><strong class="code-badge">{{ $v->code }}</strong></td>
                    <td>{{ ucfirst($v->discount_type) }}</td>
                    <td>{{ $v->discount_type === 'percent' ? $v->discount_value . '%' : '৳' . $v->discount_value }}</td>
                    <td>৳{{ number_format($v->min_order, 0) }}</td>
                    <td>{{ $v->used_count }} / {{ $v->max_uses }}</td>
                    <td>{{ $v->expires_at ? $v->expires_at->format('d M Y') : 'Never' }}</td>
                    <td>
                        <button class="toggle-btn {{ $v->is_active ? 'active' : '' }}"
                                onclick="toggleVoucher({{ $v->id }}, this)">
                            {{ $v->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td>
                        <a href="{{ route('admin.vouchers.edit', $v->id) }}" class="btn-sm">Edit</a>
                        <form action="{{ route('admin.vouchers.destroy', $v->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Delete?')">
                            @csrf @method('DELETE')
                            <button class="btn-sm btn-danger">Del</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleVoucher(id, btn) {
    fetch(`/admin/vouchers/${id}/toggle`, {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content}
    }).then(r => r.json()).then(data => {
        btn.textContent = data.active ? 'Active' : 'Inactive';
        btn.className = 'toggle-btn ' + (data.active ? 'active' : '');
    });
}
</script>
@endpush
