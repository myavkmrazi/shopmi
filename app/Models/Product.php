<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    use Sluggable;

    // ИСПРАВЛЯЕМ: gallery -> galery
    protected $fillable = ['title', 'category_id', 'price', 'old_price', 'excerpt', 'content', 'image', 'galery', 'is_hit', 'is_new'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function filters()
    {
        return $this->belongsToMany(
            \App\Models\Filter::class,
            'filter_products',
            'product_id',
            'filter_id'
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Метод правильный - работает с полем 'galery'
    protected function galery(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? json_decode($value, true) : [],
            set: fn($value) => $value ? json_encode($value) : null,
        );
    }

    // Добавьте кастинг для автоматического преобразования
    protected $casts = [
        'is_hit' => 'boolean',
        'is_new' => 'boolean',
        'price' => 'integer',
        'old_price' => 'integer',
        'galery' => 'array', // ← это тоже поможет
    ];

    public function getImage()
    {
        // 1. Проверяем основное изображение
        if ($this->image) {
            // Убираем возможный префикс public/ если есть
            $imagePath = str_replace('public/', '', $this->image);

            // Проверяем разные варианты путей
            $possiblePaths = [
                $imagePath, // как в БД: "uploads/2026/01/03/filename.jpg"
                'uploads/' . basename($imagePath), // на случай если путь странный
                'img/products/' . basename($imagePath), // альтернативный путь
            ];

            foreach ($possiblePaths as $path) {
                if (file_exists(public_path($path))) {
                    return asset($path);
                }
            }
        }

        // 2. Если нет основной картинки, берем первую из галереи
        // ИСПРАВЛЯЕМ: $this->galery вместо $this->gallery
        if (!empty($this->galery) && count($this->galery) > 0) {
            $galleryImage = $this->galery[0];

            // Если это путь, обрабатываем его
            if (is_string($galleryImage)) {
                $imagePath = str_replace('public/', '', $galleryImage);

                $possiblePaths = [
                    $imagePath,
                    'uploads/' . basename($imagePath),
                    'img/products/' . basename($imagePath),
                ];

                foreach ($possiblePaths as $path) {
                    if (file_exists(public_path($path))) {
                        return asset($path);
                    }
                }
            }
        }

        // 3. Если ничего не нашли - заглушка
        $noImagePath = 'img/no-image.jpg';
        if (file_exists(public_path($noImagePath))) {
            return asset($noImagePath);
        }

        // Альтернативные пути для заглушки
        $alternativePaths = [
            'assets/admin/img/no-image.png',
            'assets/admin/img/undraw_profile.svg',
        ];

        foreach ($alternativePaths as $path) {
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        return '';
    }

    // Дополнительный метод для удобства (опционально)
    public function getAllImages()
    {
        $images = [];

        if ($this->image) {
            $images[] = $this->image;
        }

        if (!empty($this->galery)) {
            $images = array_merge($images, $this->galery);
        }

        return $images;
    }
}
