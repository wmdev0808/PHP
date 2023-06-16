<?php

class User {
    public function profile()
    {
        // return new Profile;     
        return null;   
    }
}

class Profile {
    public function employment()
    {
        return 'web developer';
    }
}

$user = new User;

// $profile = $user->profile();

// if ($profile) {
//     echo $profile->employment();
// }

// var_dump($user->profile()?->employment()); // NULL
echo $user->profile()?->employment() ?? 'Not provided';