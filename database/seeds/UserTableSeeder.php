<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = new User;

      $user->name = "stobbsm";
      $user->email = "stobbsm@gmail.com";
      $user->password = bcrypt("gambit");
      $user->save();

    }
}
