<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Home-Page - Hope Store')]
class HomePage extends Component
{


    public function render()
    {
        $brands = Brand::where(column: 'is_active', operator: 1)->get();
        $categories = Category::where(column: 'is_active', operator: 1)->get();
        return view(
            view: 'livewire.home-page',
            data: compact(
                'brands',
                'categories'
            )
        );
    }
}
