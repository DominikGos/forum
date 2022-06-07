<div class="card  w-100 shadow">
    <div class="d-flex card-header justify-content-between flex-row gap-3">
        <a href="{{ route('profile', ['id' => $topicSegment->user->id]) }}" class="m-0 p-0 text-decoration-none">
            {{ $topicSegment->user->name }}
        </a>
        <p class="m-0 p-0">{{ $readableDate }}</p>
    </div>
    <div class="card-body">
        <p class="card-text">{{ $topicSegment->text }}</p>
        <div class="d-flex v-100 flex-row gap-2 flex-wrap">

            @if ( count($files) > 1 )

                @foreach ( $files as $file )
                    <img src="{{ $file }}" class="d-flex rounded topic-with-many-files" alt="Topic file">
                @endforeach

            @else

                @foreach ( $files as $file )
                    <img src="{{ $file }}" class="d-flex rounded topic-with-one-file" alt="Topic file">
                @endforeach

            @endif

        </div>
    </div>
</div>

