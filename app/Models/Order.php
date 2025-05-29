<?php
// app/Models/Order.php
namespace App\Models;
use App\Models\OrderItem;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'product_id', 'total', 'status', 'shipping_method', 'payment_method'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}