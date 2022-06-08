@extends('layouts.home')

@section('content')
    <div class="main-section d-flex w-100 justify-content-center p-3 pt-5">
        <div class="main-section__element mt-3 gap-3 w-50">
            <form
                action="{{ route('topic.store') }}"
                method="POST"
                class="d-flex align-items-start justify-content-start flex-column w-100"
                enctype="multipart/form-data"
            >

                @csrf

                <div class="mb-3 w-100">
                    <label for="topic" class="form-label">Topic</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="topic" aria-describedby="emailHelp">

                    @error('name')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>
                <div class="mb-3 w-100">
                    <label for="exampleFormControlTextarea1" class="form-label">Text</label>
                    <textarea class="form-control @error('text') is-invalid @enderror" name="text" id="exampleFormControlTextarea1" rows="3"></textarea>

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
                <div class="d-flex flex-row justify-content-between w-100">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="submit" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection
