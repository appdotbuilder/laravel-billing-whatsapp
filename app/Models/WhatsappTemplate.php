<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WhatsappTemplate
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $message
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|WhatsappTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WhatsappTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WhatsappTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|WhatsappTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhatsappTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhatsappTemplate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhatsappTemplate whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhatsappTemplate whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhatsappTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhatsappTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WhatsappTemplate active()
 * @method static \Illuminate\Database\Eloquent\Builder|WhatsappTemplate meterReadingRequest()
 * @method static \Illuminate\Database\Eloquent\Builder|WhatsappTemplate paymentReminder()
 * @method static \Database\Factories\WhatsappTemplateFactory factory($count = null, $state = [])
 * @method static WhatsappTemplate create(array $attributes = [])
 * @method static WhatsappTemplate firstOrCreate(array $attributes = [], array $values = [])
 * 
 * @mixin \Eloquent
 */
class WhatsappTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'message',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active templates.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include meter reading request templates.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMeterReadingRequest($query)
    {
        return $query->where('type', 'meter_reading_request');
    }

    /**
     * Scope a query to only include payment reminder templates.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaymentReminder($query)
    {
        return $query->where('type', 'payment_reminder');
    }
}