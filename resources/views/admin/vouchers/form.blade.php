@extends('layouts.admin')
@section('page-title', isset($voucher) ? 'Edit Voucher' : 'Add Voucher')

@section('content')
<div class="admin-card" style="max-width:600px">
    <form action="{{ isset($voucher) ? route('admin.vouchers.update', $voucher->id) : route('admin.vouchers.store') }}" method="POST">
        @csrf
        @if(isset($voucher)) @method('PUT') @endif

        <div class="form-grid">
            @if(!isset($voucher))
            <div class="form-group" style="grid-column:span 2">
                <label>Voucher Code *</label>
                <input type="text" name="code" value="{{ old('code') }}" placeholder="e.g. SUMMER20" style="text-transform:uppercase" required>
            </div>
            @endif
            <div class="form-group">
                <label>Discount Type *</label>
                <select name="discount_type" required>
                    <option value="percent" {{ (old('discount_type', $voucher->discount_type ?? '') === 'percent') ? 'selected' : '' }}>Percentage (%)</option>
                    <option value="fixed" {{ (old('discount_type', $voucher->discount_type ?? '') === 'fixed') ? 'selected' : '' }}>Fixed Amount (৳)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Discount Value *</label>
                <input type="number" step="0.01" name="discount_value" value="{{ old('discount_value', $voucher->discount_value ?? '') }}" required>
            </div>
            <div class="form-group">
                <label>Minimum Order (৳)</label>
                <input type="number" step="0.01" name="min_order" value="{{ old('min_order', $voucher->min_order ?? 0) }}">
            </div>
            <div class="form-group">
                <label>Max Uses</label>
                <input type="number" name="max_uses" value="{{ old('max_uses', $voucher->max_uses ?? 100) }}">
            </div>
            <div class="form-group" style="grid-column:span 2">
                <label>Expiry Date</label>
                <input type="date" name="expires_at" value="{{ old('expires_at', isset($voucher) && $voucher->expires_at ? $voucher->expires_at->format('Y-m-d') : '') }}">
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.vouchers.index') }}" class="btn-outline">Cancel</a>
            <button type="submit" class="btn-primary">{{ isset($voucher) ? 'Update' : 'Create Voucher' }}</button>
        </div>
    </form>
</div>
@endsection
