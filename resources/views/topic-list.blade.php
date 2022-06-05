@extends('home')

@section('content')

    <div class="main-section d-flex w-100 justify-content-center p-3 pt-5">
        <div class="main-section__element d-flex  align-items-center justify-content-center flex-column mt-3 gap-3 w-50">
            <div class="d-flex w-100 align-items-center fs-5 gap-3">
                Threads
                <a href="{{ route('topic.create') }}" class="btn btn-success ms-auto fs-5">Create thread</a>
            </div>
            <div class="d-flex w-100 justify-content-between align-items-center fs-5 gap-3">
                Number of threads: 20
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary fs-5">Left</button>
                    <button type="button" class="btn btn-primary fs-5">Middle</button>
                    <button type="button" class="btn btn-primary fs-5">Right</button>
                </div>
            </div>

            <div class="d-flex flex-column w-100 gap-5 mt-4">

                @foreach ($topics as $topic)
                    <div class="card shadow">
                        <div class="d-flex card-header justify-content-between flex-row gap-3 align-items-center">
                            <p class="m-0 p-0">{{ $topic->author->name }}</p>
                            <p class="m-0 p-0">12:17</p>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $topic['name'] }}</h5>
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
    </div>

@endsection
