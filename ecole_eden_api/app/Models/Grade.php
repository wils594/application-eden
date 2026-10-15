<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'subject',
        'grade',
        'coefficient',
        'term',
        'school_year',
        'scan_path',
        'entered_by',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'grade' => 'decimal:2',
            'coefficient' => 'decimal:2',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function enteredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'entered_by');
    }
}
