<?php

class User 
{
    public function cancel(bool $immediate = false)
    {
        var_dump($immediate);
    }
}

$joe = new User;

$joe->cancel();
$joe->cancel(true);
$joe->cancel(false);

$joe->cancel('next week'); // bool(true), A string will be casted into bool in non-strict type mode

