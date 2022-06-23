<?php

namespace App\Models;

use App\Events\NewsCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content'];

    protected $dispatchesEvents = [
        'created' => NewsCreated::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
