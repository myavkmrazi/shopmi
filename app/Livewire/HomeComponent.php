<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Helpers\Traits\CartTrait;

class HomeComponent extends Component
{
    use CartTrait;

    public function render()
    {
        $hits_products = Product::query()
            ->orderBy('id', 'desc')
            ->where('is_hit', '=', 1)
            ->limit(4)
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

    /**
     * Получает случайную картинку из папки products
     */
    public function getRandomProductImage()
    {
        $imageFiles = [];
        $productsPath = public_path('img/products');

        // Проверяем существует ли папка
        if (!is_dir($productsPath)) {
            return '2.jpeg'; // fallback
        }

        // Сканируем папку
        $files = scandir($productsPath);

        foreach ($files as $file) {
            // Пропускаем служебные файлы и папки
            if ($file === '.' || $file === '..' || is_dir($productsPath . '/' . $file)) {
                continue;
            }

            // Проверяем что это изображение
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $imageFiles[] = $file;
            }
        }

        // Если нашли картинки - возвращаем случайную, иначе дефолтную
        if (!empty($imageFiles)) {
            return $imageFiles[array_rand($imageFiles)];
        }

        return '2.jpeg'; // fallback
    }
}
