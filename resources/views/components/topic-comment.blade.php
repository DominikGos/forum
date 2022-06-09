<div class="card  w-100 shadow">
    <div class="d-flex card-header justify-content-between flex-row gap-3">
        <a href="{{ route('profile', ['id' => $modelTopicComment->user->id]) }}" class="m-0 p-0 text-decoration-none">
            {{ $modelTopicComment->user->name }}
        </a>
        <p class="m-0 p-0">{{ $readableDate }}</p>
    </div>
    <div class="card-body">
        <p class="card-text">{{ $modelTopicComment->text }}</p>

        @if(count($modelTopicComment->topicCommentFiles) > 0)
            <div class="d-flex v-100 flex-row gap-2 p-3 flex-wrap">

                @if ( count($modelTopicComment->topicCommentFiles) > 1 )

                    @foreach ( $modelTopicComment->topicCommentFiles as $file )
                        <img src="{{ asset($file->path) }}" class="d-flex rounded topic-with-many-files" alt="Topic file">
                    @endforeach

                @else

                    @foreach ( $modelTopicComment->topicCommentFiles as $file )
                        <img src="{{ asset($file->path) }}" class="d-flex rounded topic-with-one-file" alt="Topic file">
                    @endforeach

                @endif

            </div>
        @endif

    </div>
</div>

