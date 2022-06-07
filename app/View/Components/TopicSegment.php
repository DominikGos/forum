<?php

declare(strict_types = 1);

namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;

class TopicSegment extends Component
{
    public $topicSegment;
    public array $files = [
        /* '/images/avatar.jpg',
        '/images/avatar.jpg',
        '/images/avatar.jpg', */
    ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($topicSegment)
    {
       // dump($topicSegment);
        $this->topicSegment = $topicSegment;
    }

    public function readableDate()
    {
        return $this->topicSegment->created_at ?
            Carbon::parse($this->topicSegment->created_at)->format('H:i  M d, Y ') :
            null;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.topic-segment');
    }
}
