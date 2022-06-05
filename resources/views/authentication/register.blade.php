@extends('home')

@section('content')

    <div class="main-section d-flex w-100 justify-content-center p-5 pt-5">
        <div class="main-section__element d-flex align-items-center justify-content-center mt-3 w-50">
            <form class="w-100" action="{{ route('register') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Login</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @else
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>

                    @enderror

                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">

                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

@endsection
