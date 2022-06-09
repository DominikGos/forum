<?php

namespace App\Http\Requests;

use App\Models\TopicComment;
use Illuminate\Foundation\Http\FormRequest;

class DestroyTopicComment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $topicComment = TopicComment::find($this->route('id'));

        return $topicComment && $this->user()->id == $topicComment->user->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
