<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;


class LeaveReport extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $primaryKey = 'id';

    protected $table = 'leave_reports';

    protected $fillable = [
        'id', 'title', 'file_name', 'path'
    ];


    public static function generateUuid(){
        return Uuid::generate()->string;
    }


}
