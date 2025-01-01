<?php

namespace App\Events;

use App\Models\Upload;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ImportError
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $upload;
    /**
     * Create a new event instance.
     */
    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
    }

}
