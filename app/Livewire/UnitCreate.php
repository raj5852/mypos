<?php

namespace App\Livewire;

use App\Models\Unit;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UnitCreate extends Component
{

    public $unit_name, $related_to_unit, $operator,  $related_by_value;
    // related_to_unit


    function unitstore()
    {
        $this->validate([
            'unit_name' => ['required', 'unique:units,unit_name', 'min:1', 'max:256'],
            'related_to_unit' => ['required_with:operator,related_by_value', function ($attribute, $value, $fail) {
                if (!is_null($value)) {
                    $parts = explode('-', $value);
                    $id = $parts[0];

                    $unit = Unit::find($id);
                    if (!$unit) {
                        $fail('The selected related to unit is invalid.');
                    }
                }
            }],
            'operator' => ['nullable', 'required_with:related_to_unit,related_by_value', Rule::in('*')],
            'related_by_value' => ['nullable', 'required_with_all:related_to_unit,operator', 'numeric', 'min:0', 'max:999999999999999']
        ]);


        if (!is_null($this->related_to_unit)) {
            $parts = explode('-', $this->related_to_unit);
            $this->related_to_unit =  $parts[0];
        }

        Unit::create([
            'unit_name' => $this->unit_name ?: null,
            'related_to_unit' =>  $this->related_to_unit ?: null,
            'operator' => $this->operator ?: null,
            'related_by_value' => $this->related_by_value ?: null,
        ]);

        return to_route('units.index')->with('message', 'Unit created successfull');
    }

    public function render()
    {
        // return
        return view('livewire.unit-create', [
            'units' => Unit::get(['id', 'unit_name'])
        ]);
    }
}
