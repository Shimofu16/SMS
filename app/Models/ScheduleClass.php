<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleClass extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'date',
        'start',
        'end',
    ];

    public function schedule():BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }
}
