<div class="card  w-100 shadow">
    <div class="d-flex card-header justify-content-between flex-row gap-3">
        <a href="{{ route('profile', ['id' => $topicSegment->user->id]) }}" class="m-0 p-0 text-decoration-none">
            {{ $topicSegment->user->name }}
        </a>
        <p class="m-0 p-0">{{ $readableDate }}</p>
    </div>
    <div class="card-body">
        <p class="card-text">{{ $topicSegment->text }}</p>
    </div>
</div>

