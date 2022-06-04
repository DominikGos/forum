@extends('home')

@section('content')

    <div class="home-main-section d-flex p-5 align-items-center justify-content-center flex-column mt-3 gap-3">
        <div class="home-main-section__element d-flex w-50 align-items-center fs-5">
            Threads
            <button type="button" class="btn btn-success ms-auto fs-5">Create thread</button>
        </div>
        <div class="home-main-section__element d-flex w-50 justify-content-between align-items-center fs-5">
            Number of threads: 20
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-primary fs-5">Left</button>
                <button type="button" class="btn btn-primary fs-5">Middle</button>
                <button type="button" class="btn btn-primary fs-5">Right</button>
            </div>
        </div>

        <div class="home-main-section__element d-flex flex-column w-50 gap-5 mt-4">

            @foreach ($topics as $topic)
                <div class="card">
                    <div class="card-header">
                        {{ $topic['name'] }}
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $topic['text'] }}</p>
                        <a
                            href="{{ route( 'topic.get', [ 'id' => $topic['id'] ]) }}"
                            class="btn btn-primary"
                        >
                            Visit
                        </a>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

@endsection
