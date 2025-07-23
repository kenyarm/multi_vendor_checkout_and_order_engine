@extends('layouts.app')

@section('section_title', 'Shopping Cart')

@section('content')

  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <div class="row d-flex justify-content-center p-3 m-3">
    <div class="col-12 col-lg-10 ">
      <div class="card shadow mb-4">
        <div class="card-body">
          @if($cart->items->isEmpty())
            <p class="text-center">Your cart is empty.</p>
          @else
            <table class="table table-bordered">
              <thead>
              <tr>
              <th>Product</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Total</th>
              <th>Action</th>
              </tr>
              </thead>
              <tbody>
              @foreach($cart->items as $item)
            <tr>
              <td>{{ $item->product->name }}</td>
              <td>{{ $item->quantity }}</td>
              <td>${{ number_format($item->price, 2) }}</td>
              <td>${{ number_format($item->total, 2) }}</td>
              <td>
                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                </form>
              </td>
            </tr>
            @endforeach
              </tbody>
            </table>
            <div class="text-right">
              <h5>Total: ${{ number_format($cart->items->sum('total'), 2) }}</h5>
            </div>
            <div class="text-right mt-3 d-flex justify-content-end ">
              <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-warning btn-md ml-3">Clear Cart</button>
              </form>

              <form action="{{ route('checkout.post') }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="paid">
                <button type="submit" class="btn btn-primary btn-md ml-3">Proceed to Checkout</button>
              </form>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection