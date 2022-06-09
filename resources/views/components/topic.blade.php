<div class="card shadow w-100">
    <div class="d-flex card-header justify-content-between flex-row gap-3 align-items-center">
        <a href="{{ route('profile', ['id' => $topic->user->id]) }}" class="m-0 p-0 text-decoration-none">
            {{ $topic->user->name }}
        </a>
        <p class="m-0 p-0"> {{ $readableDate }}</p>
    </div>
    <div class="card-body">

        @if ($displayHeader)
            <h5 class="card-title">{{ $topic->name }}</h5>
        @endif

        <p class="card-text">{{ $topic->text }}</p>

        @if(count($topic->topicFiles) > 0)
            <div class="d-flex v-100 flex-row gap-2 p-3 flex-wrap">

                @if ( count($topic->topicFiles) > 1 )

                    @foreach ( $topic->topicFiles as $file )
                        <img src="{{ asset($file->path) }}" class="d-flex rounded topic-with-many-files" alt="Topic file">
                    @endforeach

                @else

                    @foreach ( $topic->topicFiles as $file )
                        <img src="{{ asset($file->path) }}" class="d-flex rounded topic-with-one-file" alt="Topic file">
                    @endforeach

                @endif

            </div>
        @endif

        @if ($displayVisitButton)
            <a href="{{ route('topic.get', ['id' => $topic->id]) }}" class="btn btn-primary">
                Visit
            </a>
        @endif

        @if ( Auth::id() == $topic->user->id )
            <a href="" class="btn btn-danger">
                Delete
            </a>
        @endif

    </div>
</div>
