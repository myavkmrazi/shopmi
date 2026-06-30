<?php

namespace App\Livewire;

use App\Helpers\Traits\CartTrait;
use App\Helpers\Traits\WishlistTrait;
use App\Models\Product;
use Livewire\Component;

class HomeComponent extends Component
{
    use CartTrait, WishlistTrait;

    public function render()
    {
        $hits_products = Product::query()
            ->orderBy('id', 'desc')
            ->where('is_hit', '=', 1)
            ->limit(8)
            ->get();

        $new_products = Product::query()
            ->orderBy('id', 'desc')
            ->where('is_new', '=', 1)
            ->limit(8)
            ->get();

        return view('livewire.home-component', [
            'hits_products' => $hits_products,
            'new_products' => $new_products,
            'title' => 'Home Page',
            'desc' => 'Description of home page',
        ]);
    }

    public function getRandomProductImage()
    {
        $imageFiles = [];
        $productsPath = public_path('img/products');

        if (! is_dir($productsPath)) {
            return '2.jpeg';
        }

        $files = scandir($productsPath);

        foreach ($files as $file) {

            if ($file === '.' || $file === '..' || is_dir($productsPath.'/'.$file)) {
                continue;
            }

            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $imageFiles[] = $file;
            }
        }

        if (! empty($imageFiles)) {
            return $imageFiles[array_rand($imageFiles)];
        }

        return '2.jpeg';
    }
}
