<?php

declare(strict_types = 1);

namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;

class TopicSegment extends Component
{
    public string $authorName;
    public string $text;
    public ?string $date;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $authorName, string $text, ?string $date)
    {
        $this->authorName = $authorName;
        $this->text = $text;
        $this->date = $date;
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
        return view('components.topic-segment');
    }
}
