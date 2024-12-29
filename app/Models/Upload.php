<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\HasMany;

class Upload extends Model
{
    protected $fillable = [
        'import_type',
        'import_type_file',
        'original_name',
        'path',
        'extension',
        'user_id'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function logs():HasMany
    {
        return $this->hasMany(Log::class);
    }

    public function audits():HasMany
    {
        return $this->hasMany(Audit::class);
    }
}
