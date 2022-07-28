<?php

namespace App\Monitoring\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $site_id
 * @property string $status
 * @property string|null $reason
 * @property \DateTimeInterface $checked_at
 * @property string $uptime_percent
 * @property int $days_online
 * @property \DateTimeInterface $created_at
 */
class SiteStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'status',
        'reason',
        'checked_at',
        'uptime_percent',
        'days_online',
        'created_at',
    ];
}
