<?php

namespace App\Livewire\Pos;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $selectedDate;
    function getproductId($id){
        dd($id);
    }

    function mount(){
        $this->selectedDate = now()->toDateString();
    }

    public function render()
    {

        return view('livewire.pos.index', [
            'products' => Product::query()->with('image')->paginate(12)
        ]);
    }
}
