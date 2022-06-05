<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;

class Topic extends Component
{
    public $topic;
    public string $date;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($topic)
    {
        $this->topic = $topic;
        $this->date = $topic->created_at;
    }

    public function readableDate()
    {
        return $this->date ?
            Carbon::parse($this->date)->format('H:i  M d, Y ') :
            null;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.topic');
    }
}
