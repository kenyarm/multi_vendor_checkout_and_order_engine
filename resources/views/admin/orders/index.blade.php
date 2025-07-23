@extends('layouts.app')
@section('section_title', 'Orders')

@section('content')
  @if(session('success'))
    <div class="alert alert-success">
    {{ session('success') }}
    </div>
  @endif

  <div class="row d-flex justify-content-center p-3 m-3">
    <div class="col-12 col-lg-10">
    <form method="GET" class="mb-3">
      <div class="row">
      <div class="col-md-3">
        <select name="vendor_id" class="form-control">
        <option value="">-- Filter by Vendor --</option>
        @foreach($vendors as $vendor)
      <option value="{{ $vendor->id }}" {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>
        {{ $vendor->name }}
      </option>
      @endforeach
        </select>
      </div>

      <div class="col-md-3">
        <select name="user_id" class="form-control">
        <option value="">-- Filter by Customer/Admin --</option>
          @foreach($users as $user)
          <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
            {{ $user->name }}
          </option>
          @endforeach
        </select>
      </div>

      <div class="col-md-3">
        <select name="status" class="form-control">
        <option value="">-- Filter by Status --</option>
        @foreach($statuses as $status)
      <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
        {{ ucfirst($status) }}
      </option>
      @endforeach
        </select>
      </div>

      <div class="col-md-3">
        <button type="submit" class="btn btn-primary w-100">Filter</button>
      </div>
      </div>
    </form>

    </div>
    <div class="col-12 col-lg-10">
    <div class="card shadow mb-4">
      <div class="card-body">
      @if($orders->isEmpty())
      <p class="text-center">No Orders</p>
    @else
      <table class="table table-bordered">
        <thead>
        <tr>
        <th>Order ID</th>
        <th>Customer Name</th>
        <th>Vendor</th>
        <th>Date</th>
        <th>Total</th>
        <th>Status</th>
        <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
      <tr>
        <td>{{ $order->id }}</td>
        <td>{{ $order->user->name }}</td>
        <td>{{ $order->vendor->name }}</td>
        <td>{{ $order->created_at->format('Y-m-d h:i:s A') }}</td>
        <td>${{ number_format($order->total, 2) }}</td>
        <td>{{ $order->payment->status }}</td>
        <td>
        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
        </td>
      </tr>
      @endforeach
        </tbody>
      </table>
      <div class="text-right">
        <h5>Total Orders: {{ $orders->count() }}</h5>
      </div>
    @endif
      </div>
    </div>
    </div>
  </div>
@endsection