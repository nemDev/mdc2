<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ProductsFile1 extends Model
{
    use Searchable;
    protected $table = 'products_file1';
    protected $fillable = ['sku', 'name', 'description'];

    public function toSearchableArray(){
        return [
            'name' => $this->name,
            'sku' => $this->sku,
            'description' => $this->description
        ];
    }
}
