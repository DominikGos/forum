@extends('home')

@section('content')

    <div class="main-section d-flex w-100 justify-content-center p-3 pt-5">
        <div class="main-section__element mt-3 gap-3 w-50">
            <form class="d-flex align-items-start justify-content-start flex-column w-100">
                <div class="mb-3 w-100">
                    <label for="topic" class="form-label">Topic</label>
                    <input type="text" class="form-control" id="topic" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text"></div>
                </div>
                <div class="mb-3 w-100">
                    <label for="exampleFormControlTextarea1" class="form-label">Text</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <select class="form-select mb-4" aria-label="Default select example">
                    <option selected>Category</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <div class="d-flex flex-row justify-content-between w-100">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="submit" class="btn btn-danger">Cancel</button>
                </div>
            </form>
        </div>
    </div>

@endsection
