<?php

use Illuminate\Database\Seeder;
use App\Models\User;    

class followersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    /**
     * 我们会使用第一个用户对除自己以外的用户进行关注，接着再让所有用户去关注第一个用户。假数据的生成代码如下所示：
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;
        
        // 获取去除掉 ID 为 1 的所有用户 ID 数组
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        // 关注除了 1 号用户以外的所有用户
        $user->follow($follower_ids);

         // 除了 1 号用户以外的所有用户都来关注 1 号用户
         foreach($followers as $follower) {
             $follower->follow($user_id);
         }

         
    }
}
