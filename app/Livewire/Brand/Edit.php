<?php

namespace App\Livewire\Brand;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;
    public $id, $name, $description, $image, $oldimage;

    function updateBrand()
    {

        $this->validate([
            'name' => ['required', 'max:256'],
            'description' => ['nullable', 'max:256'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:5000']
        ]);
        $brand = Brand::find($this->id);
        $brand->name = $this->name;
        $brand->description = $this->description;
        $brand->save();

        if ($this->image != '') {
            filedelete($this->image);
            $brand->image()->delete();
            $brand->image()->create([
                'image' => uploadimage($this->image,'brand/')
            ]);
        }

        return to_route('brand.index')->with('message', 'Brand updated successfully');
    }

    function mount($brand)
    {
        $this->id = $brand->id;
        $this->name = $brand->name;
        $this->description = $brand->description;
        $this->oldimage = $brand->image->image;
    }

    public function render()
    {
        return view('livewire.brand.edit');
    }
}
