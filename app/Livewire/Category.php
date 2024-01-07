<?php

namespace App\Livewire;

use App\Models\Category as ModelsCategory;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Category extends Component
{
    use WithFileUploads;
    public $name, $image;

    function categorystore()
    {
        $this->validate([
            'name' => ['required', 'max:256'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:5000']
        ]);

        try {
            DB::beginTransaction();
            $category = ModelsCategory::create([
                'name' => $this->name
            ]);
            if ($this->image) {
                $category->image()->create([
                    'image' => uploadimage($this->image, 'category/')
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return  to_route('category.index')->with('error', 'something is wrong');
        }


        return  to_route('category.index')->with('message', 'Category created successfully!');
    }

    public function render()
    {
        return view('livewire.category');
    }
}
