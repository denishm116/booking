<?php

namespace App\Http\Livewire;

use App\TouristObject;
use Livewire\Component;
use Livewire\WithPagination;
class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.index', ['objects' => TouristObject::query()->orderByDesc('id')->where('status', TouristObject::MODERATED)->paginate(8), 'placeholder' => 'images/placeholder.jpg']);
    }
}
