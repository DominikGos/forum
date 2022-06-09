@extends('layouts.home')

@section('content')

    <div class="main-section d-flex w-100 justify-content-center p-3 pt-5">
        <div class="main-section__element d-flex  align-items-center justify-content-center flex-column mt-3 gap-3 w-50">

            @if (session('topic-create-success'))

                <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
                    {{ session('topic-create-success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

            @endif

            <div class="d-flex w-100 align-items-center fs-5 gap-3">
                Threads
                <a href="{{ route('topic.create') }}" class="btn btn-success ms-auto fs-5">Create thread</a>
            </div>
            <div class="d-flex w-100 justify-content-between align-items-center fs-5 gap-3">
                Number of threads: {{ $numberOfTopics }}
                <div class="btn-group" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-primary fs-5">Latest</button>
                    <button type="button" class="btn btn-primary fs-5">Oldest</button>
                </div>
            </div>

            <div class="d-flex flex-column w-100 gap-5 mt-4">

                @foreach ($topics as $topic)

                    <x-topic :topic="$topic" :displayVisitButton="true" :displayHeader="true"/>

                @endforeach

            </div>
        </div>
    </div>

@endsection
