@extends('layouts.app')

@section('section_title', 'Register Form')

@section('content')
  <div class="row d-flex justify-content-center">
    <div class="col-12 col-lg-4 col-md-6">
      <div class="card shadow mb-4">
        <div class="card-body">
          <h3 class="text-center mb-4">Register</h3>
          <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
              @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>

            <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
              @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
              @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <label for="password-confirm">Confirm Password</label>
              <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
              @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
              <a href="{{ route('login') }}" class="btn btn-link btn-block">Already have an account? Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection