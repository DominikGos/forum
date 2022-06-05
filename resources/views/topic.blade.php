@extends('home')

@section('content')

    <div class="main-section d-flex w-100 justify-content-center p-3 pt-5">
        <div class="main-section__element d-flex align-items-center justify-content-center flex-column gap-3 mt-3 w-50">
            <div class="d-flex justify-content-between align-items-center fs-5 w-100 gap-3">
                <a class="btn btn-primary" href="/">Forum</a>
                <h3>
                    {{ $topic['name'] }}
                </h3>
            </div>

            <x-topic-segment :text="$topic['text']" :authorName="$topic->author->name" :date="$topic['created_at']"/>

            <div class="d-flex w-100 fs-5 mt-5 justify-content-between gap-3">
                <p>Answers: {{ $numberOfComments }} </p>
                <p class="text-primary cursor-pointer" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Write the answer
                </p>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Answer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('topic-comment.store') }}" class="d-flex align-items-start justify-content-start flex-column w-100">

                                @csrf

                                <input type="hidden" name="topic_id" value="{{ $topic['id'] }}">
                                <div class="mb-3 w-100">
                                    <label for="exampleFormControlTextarea1" class="form-label">Text</label>
                                    <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                                <div class="mb-3 w-100">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($topic->comments as $comment)

                <x-topic-segment :text="$comment->text" :authorName="$comment->author->name" :date="$comment->created_at"/>

            @endforeach

        </div>
    </div>

@endsection
