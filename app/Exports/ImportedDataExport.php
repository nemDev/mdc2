<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ImportedDataExport implements FromCollection, WithHeadings
{
    private $items;
    private $headings = [];
    public function __construct($items, $headings)
    {
        $this->items = $items;
        $this->headings = $headings;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->items;
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
