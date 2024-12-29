<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    protected $table = 'logs';
    protected $fillable = [
        'upload_id',
        'row',
        'column',
        'value',
        'message'
    ];

    public function upload():BelongsTo{
        return $this->belongsTo(Upload::class);
    }
}
