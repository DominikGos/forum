@extends('layouts.home')

@section('content')
    <div class="main-section d-flex w-100 justify-content-center flex-column align-items-center p-3 pt-5">
        <h3>Edit topic.</h3>
        <div class="main-section__element mt-3 gap-3 w-50">
            <form
                action="{{ route('topic.update', ['id' => $topic->id]) }}"
                method="POST"
                class="d-flex align-items-start justify-content-start flex-column w-100"
                enctype="multipart/form-data"
            >

                @method('put')

                @csrf

                <div class="mb-3 w-100">
                    <label for="topic" class="form-label">Topic</label>
                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        id="topic"
                        aria-describedby="emailHelp"
                        value="{{ $topic->name }}"
                    >

                    @error('name')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror
                </div>
                <div class="mb-3 w-100">
                    <label for="exampleFormControlTextarea1" class="form-label">Text</label>
                    <textarea
                        class="form-control @error('text') is-invalid @enderror"
                        name="text" id="exampleFormControlTextarea1"
                        rows="3"
                    >{{ $topic->text }}</textarea>

                    @error('text')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror
                </div>
                <div class="mb-3 w-100">
                    <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                    <input class="form-control @error('files') is-invalid @enderror" type="file" name="files[]" id="formFileMultiple" multiple>

                    @error('files')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror
                </div>

                @if(count($topic->topicFiles) > 0)
                    <div class="d-flex v-100 flex-row gap-2 p-3 flex-wrap">

                        @foreach ( $topic->topicFiles as $file )

                            @if ( count($topic->topicFiles) > 1 )
                                <div class="d-flex justify-content-center align-items-center topic-with-many-files">
                                    <img src="{{ asset($file->path) }}" class="rounded mw-100 mh-100" alt="Topic file">
                                </div>
                            @else
                                <div class="topic-with-one-file text-center w-100 p-3">
                                    <img src="{{ asset($file->path) }}" class="rounded mw-100 mh-100" alt="Topic file">
                                </div>
                            @endif

                        @endforeach

                    </div>
                @endif

                <div class="d-flex flex-row justify-content-between w-100">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('topic.get', ['id' => $topic->id]) }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
