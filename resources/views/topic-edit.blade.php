<form action="{{ route('topic.update') }}" method="POST">
@csrf
    <input type="hidden" name="id" value="{{ $id }}">
    <input type="text" name="name" id="">
    <input type="text" name="text" id="">
    <button type="submit">
        Send
    </button>
</form>
