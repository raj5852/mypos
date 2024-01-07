<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CategoryUpdate extends Component
{
    use WithFileUploads;
    public $id, $name, $oldimage, $image;

    function updateCategory()
    {

        $this->validate([
            'name' => ['required', 'max:256'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:5000']
        ]);

        try {
            DB::beginTransaction();

            $category = Category::find($this->id);
            $category->update([
                'name' => $this->name
            ]);

            if ($this->image != '') {
                filedelete($this->oldimage);

                $category->image()->delete();
                $category->image()->create([
                    'image' => uploadimage($this->image)
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return to_route('category.index')->with('error', 'Something is wrong');
        }




        return to_route('category.index')->with('message', 'Category updated successfully!');
    }


    function mount($category)
    {
        $this->id = $category->id;
        $this->name = $category->name;
        $this->oldimage = $category->image->image;
    }

    public function render()
    {
        return view('livewire.category-update');
    }
}
