<?php

namespace App\Livewire;

use App\Helpers\CartMangement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\Concerns\SweetAlert2;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert as FacadesLivewireAlert;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products Page - Hope Store')]
class ProductsPage extends Component
{
    use WithPagination, SweetAlert2;

    #[Url]
    public $selected_categories = [];

    #[Url]
    public $selected_brands = [];

    #[Url]
    public $featured = null;

    #[Url]
    public $in_stock = null;

    #[Url]
    public $on_sale = null;

    #[Url]
    public $price_range = 500;

    // added
    public function addToCart($productId)
    {
        // dd($productId);
        $total_cart_count = CartMangement::addItem($productId);
        $this->dispatch('update-cart-count', $total_cart_count)->to(Navbar::class);
        FacadesLivewireAlert::title('Product added to cart successfully!')
            ->success()
            ->show();
    }


    // sort by , price or last add
    #[Url]
    public $sort = 'latest';

    public function render()
    {
        $productQuery = Product::query()->where('is_active', true);

        if (!empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);
        }

        if (!empty($this->selected_brands)) {
            $productQuery->whereIn('brand_id', $this->selected_brands);
        }
        if ($this->featured) {
            $productQuery->where('is_featured', true);
        }
        if ($this->in_stock) {
            $productQuery->where('stock_status', 'in_stock');
        }
        if ($this->on_sale) {
            $productQuery->where('is_on_sale', true);
        }
        if ($this->price_range) {
            $productQuery->whereBetween('price', [0, $this->price_range]);
        }
        if ($this->sort === 'latest') {
            $productQuery->latest();
        } elseif ($this->sort === 'price') {
            $productQuery->orderBy('price', 'asc');
        }


        $products = $productQuery->paginate(6);

        $brands = Brand::where('is_active', true)->get(['id', 'name', 'slug']);
        $categories = Category::where('is_active', true)->get(['id', 'name', 'slug']);
        return view('livewire.products-page', compact(
            var_name: [
                'products',
                'brands',
                'categories'
            ]
        ));
    }
}
