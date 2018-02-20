<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        //获取去除掉 1 号用户的所有用户
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        // 1 号用户关注所有人
        $user->follow($follower_ids);
        // 所有人关注 1 号用户
        foreach ($followers as $follower) {
        	$follower->follow($user_id);
        }
    }
}
