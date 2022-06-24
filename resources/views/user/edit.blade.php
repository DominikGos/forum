@extends('layouts.home')

@section('content')
    <div class="main-section d-flex w-100 justify-content-center p-3 pt-5 flex-column align-items-center">
        <h3>Edit profile.</h3>
        <div class="main-section__element mt-3 gap-3 w-50">
            <div class="d-flex w-100 justify-content-center align-items-center">
                <div
                    class="profile-page-avatar-wrapper border border-3 d-flex justify-content-center align-items-center rounded-circle overflow-hidden">

                    @if ($user->avatar)
                        <img src="{{ asset($user->avatar) }}" class="profile-page-avatar " alt="profile avatar">
                    @else
                        <img src="{{ asset($avatar) }}" class="profile-page-avatar " alt="profile avatar">
                    @endif

                </div>
            </div>
            {{-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="fileToDeleteIds[]" value="{{ $file->id }}">
                                        <p class="text-danger">
                                            Delete
                                        </p>
                                    </div> --}}
            <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST"
                class="d-flex align-items-start justify-content-start flex-column w-100 mt-5" enctype="multipart/form-data">

                @method('put')

                @csrf

                <div class="mb-3 w-100">
                    <label for="topic" class="form-label">Profile login</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="topic" aria-describedby="emailHelp" value="{{ old('name') ?? $user->name }}">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-3 w-100">
                    <label for="formFile" class="form-label">Avatar.</label>
                    <input class="form-control @error('avatar') is-invalid @enderror" name="avatar" type="file"
                        id="formFile">

                    @error('avatar')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>
                @if ($user->avatar)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="deleteAvatar">
                        <p class="text-danger">
                            Delete avatar
                        </p>
                    </div>
                @endif
                <div class="d-flex flex-row justify-content-between w-100 mt-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('user.get', ['id' => $user->id]) }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
