<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\table;

class RoleSeeder extends Seeder
{

  public function run(): void
  {
    $roles = [
      ['role_name' => 'admin', 'descriptions' => 'Administrator'],
      ['role_name' => 'cashier', 'descriptions' => 'Kasir'],
      ['role_name' => 'chef', 'descriptions' => 'Koki'],
      ['role_name' => 'customer', 'descriptions' => 'Pelanggan'],
    ];

    DB::table('roles')->insert($roles);
  }
}
