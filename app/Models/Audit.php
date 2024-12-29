<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Audit extends Model
{
    protected $table = 'audits';
    protected $fillable = ['column', 'row', 'upload_id', 'old_value', 'new_value', 'model', 'model_id'];

    public function upload(): BelongsTo
    {
        return $this->belongsTo(Upload::class);
    }

}
