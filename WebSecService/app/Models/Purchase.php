<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $quantity
 * @property float $unit_price
 * @property float $total_amount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Transaction|null $transaction
 */
class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_amount',
        'status'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the user who made the purchase.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that was purchased.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the transaction associated with this purchase.
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    /**
     * Calculate the total amount for the purchase.
     */
    public function calculateTotal()
    {
        return $this->quantity * $this->unit_price;
    }

    /**
     * Process the purchase.
     */
    public function process()
    {
        if ($this->status !== 'pending') {
            throw new \Exception('Purchase has already been processed');
        }

        // Check stock availability
        if (!$this->product->hasSufficientStock($this->quantity)) {
            throw new \Exception('Insufficient stock');
        }

        // Check user credit
        if (!$this->user->hasSufficientCredit($this->total_amount)) {
            throw new \Exception('Insufficient credit');
        }

        // Decrease stock
        $this->product->decreaseStock($this->quantity);

        // Deduct user credit
        $this->user->deductCredit($this->total_amount);

        // Create transaction record
        $this->transaction()->create([
            'user_id' => $this->user_id,
            'amount' => -$this->total_amount,
            'type' => 'purchase',
            'status' => 'completed',
            'description' => "Purchase of {$this->quantity} x {$this->product->name}"
        ]);

        // Update purchase status
        $this->status = 'completed';
        $this->save();
    }
}
