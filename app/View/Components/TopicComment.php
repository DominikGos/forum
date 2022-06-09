<?php

namespace App\View\Components;

use App\Models\TopicComment as ModelTopicComment;
use Illuminate\View\Component;
use Carbon\Carbon;

class TopicComment extends Component
{
    public ModelTopicComment $comment;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ModelTopicComment $comment)
    {
        $this->comment = $comment;
    }

    public function readableDate()
    {
        return $this->comment->created_at ?
            Carbon::parse($this->comment->created_at)->format('H:i  M d, Y ') :
            null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.topic-comment');
    }
}
