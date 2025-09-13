<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\CustomerUsage
 *
 * @property int $id
 * @property int $customer_id
 * @property float $cubic_meters
 * @property int $month
 * @property int $year
 * @property float $rate_per_cubic_meter
 * @property float $total_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\Invoice|null $invoice
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerUsage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerUsage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerUsage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerUsage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerUsage whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerUsage whereCubicMeters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerUsage whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerUsage whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerUsage whereRatePerCubicMeter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerUsage whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerUsage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerUsage whereUpdatedAt($value)
 * @method static \Database\Factories\CustomerUsageFactory factory($count = null, $state = [])
 * @method static CustomerUsage create(array $attributes = [])
 * @method static CustomerUsage firstOrCreate(array $attributes = [], array $values = [])
 * 
 * @mixin \Eloquent
 */
class CustomerUsage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'customer_id',
        'cubic_meters',
        'month',
        'year',
        'rate_per_cubic_meter',
        'total_amount',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'customer_id' => 'integer',
        'cubic_meters' => 'decimal:2',
        'month' => 'integer',
        'year' => 'integer',
        'rate_per_cubic_meter' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the customer that owns this usage record.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the invoice for this usage record.
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}