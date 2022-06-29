@extends('layouts.home')

@section('content')
    <div class="main-section d-flex w-100 justify-content-center p-5 pt-5">
        <div class="main-section__element d-flex flex-column align-items-center justify-content-center mt-3 w-25">
            @if (session('status'))

                <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                    {{ session('status') }}
                    test
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            @endif
            <form class="w-100 mb-5" method="POST" action="{{ route('forgot.pasword') }}">

                @csrf

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="email" class="bg-white form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ old('email') }}">

                    @error('email')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

            @if (session('register-success'))

                <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                    {{ session('register-success') }}
                    test
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            @endif

        </div>
    </div>


@endsection
