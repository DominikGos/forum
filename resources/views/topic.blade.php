@extends('home')

@section('content')
    <div class="d-flex main-section w-100 justify-content-center p-3 pt-5">
        <div class="main-section__element d-flex align-items-center justify-content-center flex-column gap-3 mt-3 w-50">
            <div class="d-flex justify-content-between align-items-center fs-5 w-100 gap-3">
                <a class="btn btn-primary" href="/">Forum</a>
                <h3>
                    {{ $topic['name'] }}
                </h3>
            </div>
            <div class="card  w-100 shadow">
                <div class="d-flex card-header justify-content-between flex-row gap-3">
                    <p class="m-0 p-0">{{ $topic->author->name }}</p>
                    <p class="m-0 p-0">12:17</p>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $topic['text'] }}</p>
                </div>
            </div>
            <div class="d-flex w-100 fs-5 mt-5 justify-content-between gap-3">
                <p>Answers</p>
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
                            <form class="d-flex align-items-start justify-content-start flex-column w-100">
                                <div class="mb-3 w-100">
                                    <label for="exampleFormControlTextarea1" class="form-label">Text</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </div>


            @foreach ($topic->comments as $comment)
                <div class="card w-100 shadow">
                    <div class="card-header d-flex justify-content-between flex-row gap-3">
                        <p class="m-0 p-0">{{ $comment->author->name }}</p>
                        <p class="m-0 p-0">12:17</p>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{{ $comment->text }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
