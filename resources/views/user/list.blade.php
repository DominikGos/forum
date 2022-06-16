@extends('layouts.home')

@section('content')

    <div class="d-flex main-section justify-content-center p-3 pt-5">
        <div class="main-section__element flex-column d-flex gap-3 mt-3 w-50">
            <div class="d-flex justify-content-between align-items-center fs-5 w-100 gap-3">
                <a class="btn btn-primary" href="{{ route('home') }}">Forum</a>
                <h3>User list.</h3>
            </div>

            @foreach ( $users as $user )
                <div class="card shadow w-100">
                    <div class="d-flex card-header justify-content-between flex-row gap-3 align-items-center">
                        <a href="{{ route('user.get', ['id' => $user->id]) }}" class="m-0 p-0 text-decoration-none d-flex flex-row justifu-content-center align-items-center gap-3">
                            <div class="topic-user-avatar-wrapper border border-1 d-flex justify-content-center align-items-center rounded-circle overflow-hidden">

                                @if ($user->avatar)
                                    <img src="{{ asset($user->avatar) }}" class="topic-user-avatar d-block" alt="profile avatar">
                                @else
                                    <img src="{{ asset($avatar) }}" class="profile-page-avatar d-block" alt="profile avatar">
                                @endif

                            </div>
                            {{ $user->name }}
                        </a>
                    </div>
                    <div class="card-body mt-">
                        <h5 class="card-title">Role</h5>
                        <a href="{{ route('user.get', ['id' => $user->id]) }}" class="btn btn-primary">Profile</a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection
