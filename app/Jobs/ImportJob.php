<?php

namespace App\Jobs;

use App\Events\ImportError;
use App\Imports\FileImport;
use App\Models\Upload;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $uploadId;
    protected $uploadedFilePath;
    /**
     * Create a new job instance.
     */
    public function __construct(int $uploadId, string $uploadedFilePath)
    {
        $this->uploadId     = $uploadId;
        $this->uploadedFilePath = $uploadedFilePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Excel::import(new FileImport($this->uploadId), $this->uploadedFilePath);
        }catch (\Exception $exception){
            //Send email
            $upload = Upload::find($this->uploadId);
            event(new ImportError($upload));
        }
    }


}
