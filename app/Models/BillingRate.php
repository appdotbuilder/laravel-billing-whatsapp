<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BillingRate
 *
 * @property int $id
 * @property float $price_per_cubic_meter
 * @property int $month
 * @property int $year
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRate query()
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRate wherePricePerCubicMeter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRate whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRate whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRate whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BillingRate active()
 * @method static \Database\Factories\BillingRateFactory factory($count = null, $state = [])
 * @method static BillingRate create(array $attributes = [])
 * @method static BillingRate firstOrCreate(array $attributes = [], array $values = [])
 * 
 * @mixin \Eloquent
 */
class BillingRate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'price_per_cubic_meter',
        'month',
        'year',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price_per_cubic_meter' => 'decimal:2',
        'month' => 'integer',
        'year' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active rates.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}