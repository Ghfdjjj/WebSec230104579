<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property float $amount
 * @property string $type
 * @property string $status
 * @property int|null $purchase_id
 * @property int|null $processed_by
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Purchase|null $purchase
 * @property-read \App\Models\User|null $processor
 */
class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'status',
        'purchase_id',
        'processed_by',
        'description'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    /**
     * Get the user associated with the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the purchase associated with the transaction.
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    /**
     * Get the user who processed the transaction.
     */
    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Process a credit addition transaction.
     */
    public static function addCredit($user, $amount, $processedBy = null, $description = null)
    {
        $transaction = new static([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'credit_add',
            'status' => 'completed',
            'processed_by' => $processedBy?->id,
            'description' => $description ?? "Credit addition of {$amount}"
        ]);

        $transaction->save();
        $user->addCredit($amount);

        return $transaction;
    }
}
