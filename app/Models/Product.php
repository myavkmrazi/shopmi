<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use Sluggable;

    protected $fillable = [
        'title',
        'category_id',
        'price',
        'old_price',
        'excerpt',
        'content',
        'image',
        'gallery',
        'is_hit',
        'is_new',
        'stock',
    ];

    protected $casts = [
        'is_hit' => 'boolean',
        'is_new' => 'boolean',
        'price' => 'integer',
        'old_price' => 'integer',
        'stock' => 'integer',
        'gallery' => 'array',
    ];

    public function inStock(): bool
    {
        return (int) ($this->stock ?? 0) > 0;
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function filters()
    {
        return $this->belongsToMany(
            Filter::class,
            'filter_products',
            'product_id',
            'filter_id'
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getImage()
    {
        if ($this->image) {
            $image = $this->findPublicImage($this->image);

            if ($image) {
                return $image;
            }
        }

        if (!empty($this->gallery)) {
            $image = $this->findPublicImage($this->gallery[0] ?? '');

            if ($image) {
                return $image;
            }
        }

        foreach ([
            'img/no-image.jpg',
            'assets/admin/img/no-image.png',
            'assets/admin/img/undraw_profile.svg',
        ] as $path) {
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        return '';
    }

    public function getAllImages(): array
    {
        $images = [];

        if ($this->image) {
            $images[] = $this->image;
        }

        if (!empty($this->gallery)) {
            $images = array_merge($images, $this->gallery);
        }

        return $images;
    }

    private function findPublicImage(string $image): ?string
    {
        if ($image === '') {
            return null;
        }

        $imagePath = str_replace('public/', '', $image);
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

        return null;
    }
}
