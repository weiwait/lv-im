<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'source', 'to', 'type', 'payload',
    ];

    const SOURCE = [
        'group',
        'friend',
    ];

    const TYPE = [
        'string',
        'image',
    ];

    public function source(): Attribute
    {
        return Attribute::make(
            get: fn($v) => self::SOURCE[$v],
            set: fn($v) => array_search($v, self::SOURCE)
        );
    }

    public function type(): Attribute
    {
        return Attribute::make(
            get: fn($v) => self::TYPE[$v],
            set: fn($v) => array_search($v, self::TYPE)
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        self::created(function (self $message) {
            $message->loadMissing(['user']);
            broadcast(new \App\Events\Message($message));
        });
    }
}
