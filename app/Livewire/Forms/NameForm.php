<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class NameForm extends Form
{
    public $name = '';

    public function rules()
    {
        return [
            'name' => [
                'required',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\']+$/',
                'min:3'
            ],
        ];
    }
}
