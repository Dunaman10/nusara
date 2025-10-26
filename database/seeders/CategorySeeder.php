<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{

  public function run(): void
  {
    $category = [
      ['cat_name' => 'Makanan', 'description' => 'Makanan'],
      ['cat_name' => 'Minuman', 'description' => 'Minuman'],
    ];

    DB::table('categories')->insert($category);
  }
}
