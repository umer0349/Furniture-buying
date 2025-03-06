<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'price', 'image'];

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    protected function title(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value), // Accessor (Show hone pe first letter capital)
            set: fn ($value) => strtolower($value) // Mutator (Store hone pe lowercase)
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            if ($product->image) {
                $imagePath = public_path('gallery/product/'.$product->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
        });
    }
}
