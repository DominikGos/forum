@extends('home')

@section('content')

    <table>
        <tr>
            <th>
                topic
            </th>
            <th>
                text
            </th>
            <th>
                author
            </th>
        </tr>
        <tr>
            <td>
                {{ $topic['name'] }}
            </td>
            <td>
                , {{ $topic['text'] }}
            </td>

            <td>
                , {{ $topic->author->name }}
            </td>
            <td>
                <a href="{{ route('topic.edit', ['id' => $topic['id'] ]) }}">EDYTUJ</a>
            </td>
        </tr>
    </table>


    <h3>
        Comments
    </h3>

    <br>

    <table>
        <tr>
            <th>Author</th>
            <th>text</th>
        </tr>
        @foreach ($topic->comments as $comment)
            <tr>
                <td>
                    {{ $comment->author->name }}
                </td>
                <td>
                    , {{ $comment->text }}
                </td>
            </tr>
        @endforeach

    </table>


@endsection
