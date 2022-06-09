<?php

namespace App\View\Components;

use App\Models\Topic as ModelTopic;
use Illuminate\View\Component;
use Carbon\Carbon;

class Topic extends Component
{
    public $topic;
    public bool $displayVisitButton;
    public bool $displayHeader;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(ModelTopic $topic, bool $displayVisitButton, bool $displayHeader)
    {
        $this->topic = $topic;
        $this->displayVisitButton = $displayVisitButton;
        $this->displayHeader = $displayHeader;
    }

    public function readableDate()
    {
        return $this->topic->created_at ?
            Carbon::parse($this->topic->created_at)->format('H:i  M d, Y ') :
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
