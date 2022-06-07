@extends('layouts.home')

@section('content')

    <div class="d-flex main-section justify-content-center p-3 pt-5">
        <div class="main-section__element flex-column d-flex gap-3 mt-3 w-50">
            <div class="d-flex flex-column justify-content-center align-items-center fs-5 w-100 gap-3">
                <div class="profile-page-avatar-wrapper border border-3 d-flex justify-content-center align-items-center rounded-circle overflow-hidden">

                    @if ($user->avatar)
                        <img src="{{ $user->avatar }}" class="profile-page-avatar d-block" alt="profile avatar">
                    @else
                        <img src="/images/avatar.jpg" class="profile-page-avatar d-block" alt="profile avatar">
                    @endif

                </div>
                <h3> {{ $user->name }} </h3>
            </div>
            <div class="d-flex justify-content-between"></div>
            <div class="d-flex justify-content-center fs-5 w-100 gap-3">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item">
                        <a
                            class="nav-link @if($dataToDisplay === 'threads') active @endif"
                            href="{{ route('profile', ['id' => $user->id, 'data-to-display' => 'threads']) }}"
                        >
                            Threads posted
                        </a>
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link @if($dataToDisplay === 'comments') active @endif"
                            href="{{ route('profile', ['id' => $user->id, 'data-to-display' => 'comments']) }}"
                        >
                            Comments posted
                        </a>
                    </li>
                </ul>
            </div>
            <div class="d-flex flex-column w-100 gap-5 mt-4">

                @if($dataToDisplay === 'threads')

                    @foreach ($user->topics as $topic)
                        <x-topic :topic="$topic"/>
                    @endforeach

                @else

                    @foreach ($userComments as $comment)
                        <x-topic-segment :topicSegment="$comment"/>
                    @endforeach

                @endif

            </div>
        </div>
    </div>

@endsection
