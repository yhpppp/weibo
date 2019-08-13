<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
  
    public function run()
    {
        // 假数据的生成顺序进行设定。
        
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(StatusesTableSeeder::class);
        $this->call(followersTableSeeder::class);

        Model::reguard();
    }
}
