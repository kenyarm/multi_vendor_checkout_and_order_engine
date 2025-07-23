@extends('layouts.app')

@section('section_title', 'Login Form')

@section('content')
  <div class="row d-flex justify-content-center">

    <div class="col-12 col-lg-4 col-md-6">
    <div class="card shadow mb-4">
      <div class="card-body">
      <h3 class="text-center mb-4">Login</h3>
      <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
        @if ($errors->has('email'))
      <span class="text-danger">{{ $errors->first('email') }}</span>
      @endif
        </div>
        <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required
          value="{{ old('password') }}">
        @if ($errors->has('password'))
      <span class="text-danger">{{ $errors->first('password') }}</span>
      @endif
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
      </form>
      </div>
    </div>
    </div>
  </div>
@endsection