<?php

// In PHP 7.4, Union type notation
// class User
// {
//     public function makeFriendsWith(?User $user)
//     {
//         var_dump('Yay friends');
//     }
// }

// $joe = new User;
// $sam = new User;

// $joe->makeFriendsWith($sam); // Yay friends
// $joe->makeFriendsWith(null); // Still works, outputing Yay friends

// In PHP 7, you can use DocTypes

// class User
// {
//     /**
//      * @param User|string $user
//      */
//     public function makeFriendsWith($user)
//     {
//         var_dump('Yay friends');
//     }
// }

// $joe = new User;
// $sam = new User;

// $joe->makeFriendsWith('same@example.com');

// In PHP 8

class User
{
    public function makeFriendsWith(User|string $user)
    {
        var_dump('Yay friends');
    }
}

$joe = new User;
$sam = new User;

$joe->makeFriendsWith($sam); // Yay friends
$joe->makeFriendsWith('same@example.com'); // Still works, outputing Yay friends