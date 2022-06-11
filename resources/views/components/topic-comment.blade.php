<div class="card  w-100 shadow">
    <div class="d-flex card-header justify-content-between flex-row gap-3">
        <a href="{{ route('profile', ['id' => $comment->user->id]) }}" class="m-0 p-0 text-decoration-none d-flex flex-row justifu-content-center align-items-center gap-3">
            <div class="topic-user-avatar-wrapper border border-1 d-flex justify-content-center align-items-center rounded-circle overflow-hidden">

                @if ($comment->user->avatar)
                    <img src="{{ asset($comment->user->avatar) }}" class="topic-user-avatar d-block" alt="profile avatar">
                @else
                    <img src="{{ asset($avatar) }}" class="profile-page-avatar d-block" alt="profile avatar">
                @endif

            </div>
            {{ $comment->user->name }}
        </a>
        <p class="m-0 p-0">{{ $readableDate }}</p>
    </div>
    <div class="card-body">
        <p class="card-text">{{ $comment->text }}</p>

        @if( count($comment->topicCommentFiles) > 0)
            <div class="d-flex v-100 flex-row gap-2 p-3 flex-wrap">

                @foreach ( $comment->topicCommentFiles as $file )

                    @if ( count($comment->topicCommentFiles) > 1 )
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

            @if ( Auth::id() == $comment->user->id )
                <form
                    action="{{ route('topic.comment.destroy', ['id' => $comment->id]) }}"
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

