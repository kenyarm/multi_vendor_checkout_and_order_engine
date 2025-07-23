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
          <h5>Order ID: {{ $order->id }}</h5>
          <p>Date: {{ $order->created_at->format('Y-m-d') }}</p>
          <p>Total: ${{ number_format($order->total, 2) }}</p>
          <p>Status: {{ $order->payment->status }}</p>
          <h5>Items:</h5>
          @if($order->items->isEmpty())
            <p class="text-center">No Items in this Order</p>
          @else
            <table class="table table-bordered">
              <thead>
              <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
              </tr>
              </thead>
              <tbody>
              @foreach($order->items as $item)
                <tr>
                  <td>{{ $item->product->name }}</td>
                  <td>{{ $item->quantity }}</td>
                  <td>${{ number_format($item->price, 2) }}</td>
                </tr>
              @endforeach
              </tbody>
            </table>
            <div class="text-right">
              <h5>Total Items: {{ $order->items->count() }}</h5>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
