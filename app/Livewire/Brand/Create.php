<?php

namespace App\Livewire\Brand;

use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public $name, $description, $image;

    function brandstore()
    {
        $this->validate([
            'name' => ['required', 'max:256'],
            'description'=>['nullable','max:256'],
            'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:5000']
        ]);

        try {
            DB::beginTransaction();
            $brand = Brand::create([
                'name' => $this->name,
                'description'=>$this->description
            ]);

            if ($this->image) {
                $brand->image()->create([
                    'image' => uploadimage($this->image, 'brand/')
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollBack();
            return  to_route('brand.index')->with('error', 'something is wrong');
        }

        return  to_route('brand.index')->with('message', 'Brand created successfully!');

    }

    public function render()
    {
        return view('livewire.brand.create');
    }
}
