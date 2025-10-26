<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Testing\Fluent\Concerns\Has;

class Order extends Model
{
  use SoftDeletes, HasFactory;

  protected $fillable = ['order_code', 'user_id', 'subtotal', 'tax', 'grand_total', 'status', 'table_number', 'payment_method', 'note', 'created_at', 'updated_at'];
  protected $dates = ['deleted_at'];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function orderItems()
  {
    return $this->hasMany(OrderItem::class);
  }
}
