<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class OrdersFile2 extends Model
{
    use Searchable;

    protected $table = 'orders_file2';
    protected $primaryKey = 'id';
    protected $fillable = ['order_date','channel','sku','origin','su_num','cost','shipping_cost','total_price', 'notes'];

    public function toSearchableArray(){
        return [
            'order_date' => $this->order_date,
            'channel' => $this->channel,
            'sku' => $this->sku,
            'origin' => $this->origin,
            'su_num' => $this->su_num,
            'cost' => $this->cost,
            'shipping_cost' => $this->shipping_cost,
            'total_price' => $this->total_price,
            'notes' => $this->item_description,
        ];
    }
}
