<?php

namespace App\Http\Livewire;

use App\Models\Content\Post\Post;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class LiveSearch extends Component
{
    public $search = '';

    protected $queryString = [
        'search'
    ];

    public function render()
    {
        $queryPost = Post::query()->publish();

        if ($this->search != '') {
            $queryPost->where('title->'.App::getLocale(), 'like', '%'.$this->search.'%')
                ->orWhere('intro->'.App::getLocale(), 'like', '%'.$this->search.'%')
                ->orWhere('content->'.App::getLocale(), 'like', '%'.$this->search.'%')
                ->orWhere('meta_data->title', 'like', '%'.$this->search.'%')
                ->orWhere('meta_data->description', 'like', '%'.$this->search.'%')
                ->orWhere('meta_data->keywords', 'like', '%'.$this->search.'%');
        }
        
        $data['post'] = $queryPost->limit(5)->get();

        return view('livewire.live-search', compact('data'));
    }
}
