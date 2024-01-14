<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'product';

    protected $fillable = [
        'code',
        'name',
        'specification',
        'uom',
        'isActive',
        'category_id',
    ];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('Y-m-d H:i:s');
    }
    
    public function hasCategory() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function hasStock() {
        return $this->hasOne(Stock::class, 'product_id');
    }

    public function hasPurchase() {
        return $this->hasMany(Purchase::class, 'product_id');
    }
}
