<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index(User $user)
    {   
        if( ! $user_list = redisKeyExist('top_user_list',1) ) {

            $topUsersData = $user->users();

            redisSetData( 'top_user_list', $topUsersData, 86400 );

            /**
             * @var $topUsersData
             * Now this is our requred array of top users list, we can do whatever we want with this array of users. We can insert it via queue job, or somethings others.
             */
        }

        return $user_list;
    }
}
