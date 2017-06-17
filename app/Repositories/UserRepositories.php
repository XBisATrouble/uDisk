<?php
/**
 * Created by PhpStorm.
 * User: xb
 * Date: 2017/6/17
 * Time: 下午9:26
 */

namespace App\Repositories;


use App\Models\User;

class UserRepositories
{
    public function getUserFeed($id)
    {
        return User::with('files')->find($id);
    }
}