<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Invoice
 *
 * @property int $id
 * @property string $invoice_number
 * @property int $customer_id
 * @property int $customer_usage_id
 * @property float $amount
 * @property string $status
 * @property string $due_date
 * @property int $month
 * @property int $year
 * @property float|null $payment_amount
 * @property string|null $payment_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\CustomerUsage $customerUsage
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereInvoiceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCustomerUsageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice paid()
 * @method static \Illuminate\Database\Eloquent\Builder|Invoice unpaid()
 * @method static \Database\Factories\InvoiceFactory factory($count = null, $state = [])
 * @method static Invoice create(array $attributes = [])
 * @method static Invoice firstOrCreate(array $attributes = [], array $values = [])
 * 
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'invoice_number',
        'customer_id',
        'customer_usage_id',
        'amount',
        'status',
        'due_date',
        'month',
        'year',
        'payment_amount',
        'payment_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'customer_id' => 'integer',
        'customer_usage_id' => 'integer',
        'amount' => 'decimal:2',
        'month' => 'integer',
        'year' => 'integer',
        'payment_amount' => 'decimal:2',
        'due_date' => 'date',
        'payment_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the customer that owns this invoice.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the customer usage record for this invoice.
     */
    public function customerUsage(): BelongsTo
    {
        return $this->belongsTo(CustomerUsage::class);
    }

    /**
     * Scope a query to only include paid invoices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope a query to only include unpaid invoices.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }
}