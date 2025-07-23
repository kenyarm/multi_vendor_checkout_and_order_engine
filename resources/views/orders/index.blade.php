@extends('layouts.app')
@section('section_title', 'Orders')

@section('content')
  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  <div class="row d-flex justify-content-center p-3 m-3">
    <div class="col-12 col-lg-10 ">
      <div class="card shadow mb-4">
        <div class="card-body">
          @if($orders->isEmpty())
            <p class="text-center">No Orders</p>
          @else
            <table class="table table-bordered">
              <thead>
              <tr>
                <th>Order ID</th>
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
                  <td>{{ $order->vendor->name }}</td>
                  <td>{{ $order->created_at->format('Y-m-d') }}</td>
                  <td>${{ number_format($order->total, 2) }}</td>
                  <td>{{ $order->payment->status }}</td>
                  <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
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
