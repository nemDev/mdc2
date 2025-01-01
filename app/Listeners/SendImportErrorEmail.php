<?php

namespace App\Listeners;

use App\Events\ImportError;
use App\Mail\ImportErrorMail;
use Illuminate\Support\Facades\Mail;

class SendImportErrorEmail
{
    /**
     * Handle the event.
     */
    public function handle(ImportError $event): void
    {
        $upload = $event->upload;
        Mail::to($upload->user->email)->send(new ImportErrorMail($upload));
    }
}
