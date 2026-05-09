@extends('layouts.admin')
@section('page-title', 'Client Database')

@section('content')
<div class="admin-card">
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>Name</th><th>Email</th><th>Phone</th><th>Orders</th><th>Joined</th><th>Action</th></tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td><strong>{{ $client->name }}</strong></td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->phone ?? '—' }}</td>
                    <td><span class="badge badge-info">{{ $client->orders_count }} orders</span></td>
                    <td>{{ $client->created_at->format('d M Y') }}</td>
                    <td><a href="{{ route('admin.clients.show', $client->id) }}" class="btn-sm">View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $clients->links() }}
</div>
@endsection
