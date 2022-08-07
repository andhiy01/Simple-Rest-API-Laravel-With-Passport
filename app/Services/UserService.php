<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getAllUser()
    {
        /**
         * get all user
         *
         * 
         *
         * @return \App\Models\User
         */
        $user = User::paginate(10);

        return $user;
    }

    public function getSearchUser(string $search)
    {
        /**
         * get user data by name or email
         *
         * @param string $search
         *
         * @return \App\Models\User
         */
        $user = User::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->paginate(10);

        return $user;
    }

    public function addUser(array $data)
    {
        /**
         * add new user
         *
         * @param array $data
         *
         * @return \App\Models\User
         */
        $user = User::create($data);

        return $user;
    }

    public function updateUser(array $data, $user)
    {
        /**
         * edit data user
         *
         * @param array $data
         * @param array $user
         *
         * @return \App\Models\User
         */
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->update($data);

        return $user;
    }

    public function deleteUser($user)
    {
        /**
         * edit data user
         *
         * @param array $data
         * @param array $user
         *
         * @return \App\Models\User
         */
        $user->delete();

        return $user;
    }
}
