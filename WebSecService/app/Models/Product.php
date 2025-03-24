<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property int $stock_quantity
 * @property string|null $image_url
 * @property bool $is_active
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Purchase[] $purchases
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity',
        'image_url',
        'is_active',
        'created_by'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get the user who created the product.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the purchases for the product.
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Check if the product has sufficient stock for a purchase.
     */
    public function hasSufficientStock($quantity)
    {
        return $this->stock_quantity >= $quantity;
    }

    /**
     * Decrease the product stock.
     */
    public function decreaseStock($quantity)
    {
        if (!$this->hasSufficientStock($quantity)) {
            throw new \Exception('Insufficient stock');
        }
        $this->stock_quantity -= $quantity;
        $this->save();
    }

    /**
     * Increase the product stock.
     */
    public function increaseStock($quantity)
    {
        $this->stock_quantity += $quantity;
        $this->save();
    }
}