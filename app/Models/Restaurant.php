<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'name',
    'slug',
    'address',
    'phone',
    'email',
    'logo',
    'domain',
    'is_active',
  ];

  protected $casts = [
    'is_active' => 'boolean',
  ];

  public function tables()
  {
    return $this->hasMany(Table::class);
  }

  public function users()
  {
    return $this->hasMany(User::class);
  }
}
