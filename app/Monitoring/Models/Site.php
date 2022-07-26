<?php

namespace App\Monitoring\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $domain
 * @property \DateTimeInterface $created_at
 */
class Site extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'domain',
        'created_at',
    ];
}
