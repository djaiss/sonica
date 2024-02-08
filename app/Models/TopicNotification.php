<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopicNotification extends Model
{
    use HasFactory;

    public const STRATEGY_CHANNEL = 'channel';

    public const STRATEGY_USERS = 'users';

    public const STRATEGY_NONE = 'none';

    protected $table = 'topic_notifications';

    protected $fillable = [
        'user_id',
        'topic_id',
        'read',
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }
}
