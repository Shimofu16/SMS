<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Model;
use Kenepa\ResourceLock\Models\Concerns\HasLocks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'body',
        'attachments',
        'links',
        'send_to_roles',
    ];

    protected $casts =  [
        'attachments' => Json::class,
        'links' => Json::class,
        'send_to_roles' => Json::class,
    ];
}
