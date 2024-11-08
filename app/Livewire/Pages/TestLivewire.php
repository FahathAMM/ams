<?php

namespace App\Livewire\Pages;

use App\Models\Task\Task;
use Livewire\Component;

class TestLivewire extends Component
{
    public $posts, $title, $content, $postId;

    public function mount()
    {
        $this->posts = Task::all();
    }

    public function edit($id)
    {
        $post = Task::find(12);
        dd($post);
    }

    public function render()
    {
        return view('livewire.pages.test-livewire');
    }
}
