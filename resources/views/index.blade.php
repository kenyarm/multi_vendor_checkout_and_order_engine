@extends('layouts.app')
@section('section_title', 'Welcome to Our Store')

@section('content')
  @if (session('success'))
    <div class="alert alert-success" role="alert">
      {{ session('success') }}
    </div> 
  @endif
  <div class="row d-flex justify-content-center">
    <div class="col-lg-10">
    <div class="row d-flex justify-content-center">
      @if ($products->isEmpty())
      <div class="col-12">
      <div class="alert alert-info" role="alert">
      No products available at the moment.
      </div>
      </div>
    @else
      @foreach ($products as $product)
      <div class="col-lg-4 col-md-6 mb-4">
      <div class="card mb-4">
      <div class="card-body">
      <h5 class="card-title">{{ $product->name }}</h5>
      <p class="card-text">{{ $product->description }}</p>
      <p class="card-text"><strong>Stock:</strong> {{ $product->stock > 0 ? $product->stock : 'Out of Stock' }}</p>
      <p class="card-text"><strong>Price:</strong> ${{ $product->price }}</p>
      <p class="cart-text">Vendor: {{ $product->vendor->name }}</p>

      @if($product->stock > 0)
        <form action="{{ route('cart.add', $product->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>
      @else
      <button class="btn btn-danger" disabled>Out of Stock</button>
      @endif
      </div>
      </div>
      </div>
    @endforeach
    @endif
    </div>
    </div>
  </div>
@endsection