<div class="card shadow w-100">
    <div class="d-flex card-header justify-content-between flex-row gap-3 align-items-center">
        <a href="{{ route('profile', ['id' => $topic->user->id]) }}" class="m-0 p-0 text-decoration-none d-flex flex-row justifu-content-center align-items-center gap-3">
            <div class="topic-user-avatar-wrapper border border-1 d-flex justify-content-center align-items-center rounded-circle overflow-hidden">

                @if ($topic->user->avatar)
                    <img src="{{ asset($topic->user->avatar) }}" class="topic-user-avatar d-block" alt="profile avatar">
                @else
                    <img src="{{ asset($avatar) }}" class="profile-page-avatar d-block" alt="profile avatar">
                @endif

            </div>
            {{ $topic->user->name }}
        </a>
        <p class="m-0 p-0">
            {{ $readableDate }}

            @if ( $topic->updated )
                <strong>
                    ( Edited )
                </strong>
            @endif

        </p>
    </div>
    <div class="card-body">

        @if ($displayHeader)
            <h5 class="card-title">{{ $topic->name }}</h5>
        @endif

        <p class="card-text">{{ $topic->text }}</p>

        @if(count($topic->topicFiles) > 0)
            <div class="d-flex w-100 flex-row gap-2 p-3 flex-wrap">

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

        <div class="d-flex flex-row gap-2">

            @if ($displayVisitButton)
                <a href="{{ route('topic.get', ['id' => $topic->id]) }}" class="btn btn-primary">
                    Visit
                </a>
            @endif

            @if ( Auth::id() == $topic->user->id )
                <a href="{{ route('topic.edit', ['id' => $topic->id]) }}" class="btn btn-primary">
                    Edit
                </a>
                <form
                    action="{{ route('topic.destroy', ['id' => $topic->id]) }}"
                    method="POST"
                >

                    @csrf

                    @method('delete')

                    <button type="submit" class="btn btn-danger">
                        Delete
                    </button>
                </form>
            @endif

        </div>


    </div>
</div>
