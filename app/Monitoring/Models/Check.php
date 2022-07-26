<?php

namespace App\Monitoring\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \DateTimeInterface $date
 * @property int $site_id
 * @property string $status
 * @property string|null $reason
 * @property \DateTimeInterface $created_at
 */
class Check extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date',
        'site_id',
        'status',
        'reason',
        'created_at',
    ];
}
