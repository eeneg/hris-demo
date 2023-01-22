<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Webpatser\Uuid\Uuid;

class LeaveReport extends Auditable
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $table = 'leave_reports';

    protected $fillable = [
        'id', 'title', 'file_name', 'path',
    ];

    public static function generateUuid()
    {
        return Uuid::generate()->string;
    }
}
