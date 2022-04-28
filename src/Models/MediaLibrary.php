<?php

namespace Papaedu\Extension\Models;

use Illuminate\Database\Eloquent\Model;
use Papaedu\Extension\Models\Methods\MediaLibraryMethod;

class MediaLibrary extends Model
{
    use MediaLibraryMethod;

    protected $fillable = [
        'type',
        'path',
        'height',
        'width',
        'status',
    ];

    public const EXPIRED_DAYS = 1;

    public const SCAN_TASK_IDS_KEY = 'st:ids';
}
