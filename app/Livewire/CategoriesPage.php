<?php

namespace App\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Categories - Hope Store')]
class CategoriesPage extends Component
{
    public function render()
    {
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('livewire.categories-page', compact('categories'));
    }
}
