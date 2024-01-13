<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'specification',
        'uom',
        'isActive',
        'category_id',
    ];

    public function hasCategory() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function hasStock() {
        return $this->hasOne(Stock::class, 'product_id');
    }
}
