@extends('layouts.app')
@section('section_title', 'Admin Dashboard')

@section('content')
  <div class="container">
    <div class="mt-4">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary">View All Orders</a>
    </div>

    <div class="row my-4">
    <div class="col-md-3 mb-3">
      <div class="card text-center">
      <div class="card-body">
        <h5 class="card-title">Total Orders</h5>
        <p class="card-text">{{ $ordersCount }}</p>
      </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card text-center">
      <div class="card-body">
        <h5 class="card-title">Total Admins</h5>
        <p class="card-text">{{ $adminsCount }}</p>
      </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card text-center">
      <div class="card-body">
        <h5 class="card-title">Total Products</h5>
        <p class="card-text">{{ $productsCount }}</p>
      </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card text-center">
      <div class="card-body">
        <h5 class="card-title">Total Users</h5>
        <p class="card-text">{{ $usersCount }}</p>
      </div>
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <div class="card text-center">
      <div class="card-body">
        <h5 class="card-title">Total Vendors</h5>
        <p class="card-text">{{ $vendorsCount }}</p>
      </div>
      </div>
    </div>

    </div>
  @endsection