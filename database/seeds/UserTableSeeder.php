<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      if (DB::table('users')->get()->count() != 0) {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
      }

      $users = [
        [
          'name'=> 'admin@transisi.id',
          'email'=> 'admin@transisi.id',
          'password'   => bcrypt('transisi'),
          'created_at' => now(),
          'updated_at' => now(),
        ]
      ];

      foreach ($users as $user) {
        \App\User::create($user);
      }
    }
}
