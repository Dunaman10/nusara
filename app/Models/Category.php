<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
  use SoftDeletes;

  protected $fillable = ['cat_name', 'description', 'restaurant_id'];
  protected $dates = ['deleted_at'];

  public function items()
  {
    return $this->hasMany(Item::class);
  }

  public function restaurant()
  {
    return $this->belongsTo(Restaurant::class);
  }
}
