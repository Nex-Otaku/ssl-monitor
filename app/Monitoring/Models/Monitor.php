<?php

namespace App\Monitoring\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_tg_id
 * @property int $site_id
 * @property \DateTimeInterface $created_at
 */
class Monitor extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_tg_id',
        'site_id',
        'created_at',
    ];
}
