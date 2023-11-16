<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\TodoFactory;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'is_completed',
    ];

    protected $guarded = [];

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return TodoFactory::new();
    }

    /**
     * Get the user that owns the todo
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
