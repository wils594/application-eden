<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
   protected $fillable = [
    'title',
    'content',
    'attachment',
    'category',
    'published_at',
    'status',
    'target_all_parents',
    'target_classes',
    'created_by',
];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'target_all_parents' => 'boolean',
            'target_classes' => 'array',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
