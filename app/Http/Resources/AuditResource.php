<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use \Illuminate\Support\Facades\Config;

class AuditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $importTypes = Config::get("import_types");

        return  [
            'id' => $this->id,
            'row' => $this->row,
            'column' => $importTypes[$this->upload->import_type]['files'][$this->upload->import_type_file]['header_to_db'][$this->column]['label'],
            'upload' => $this->upload,
            'importType' => $importTypes[$this->upload->import_type]['label'],
            'importTypeFile' => $importTypes[$this->upload->import_type]['files'][$this->upload->import_type_file]['label'],
            'old_value' => $this->old_value,
            'new_value' => $this->new_value
        ];
    }
}
