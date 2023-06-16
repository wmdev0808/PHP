<?php

class User 
{
    // protected $name;

    // public function __construct($name)
    // {
    //     $this->name = $name;
    // }

    public function __construct(protected $name)
    {
        
    }
}

class Plan
{
    // protected $name;

    // public function __construct($name)
    // {
    //     $this->name = $name;
    // }

    public function __construct(protected string $name = 'monthly') 
    {
       
    }

}

class Signup
{
    // protected User $user;

    // protected Plan $plan;

    // public function __construct(User $user, Plan $plan)
    // {
    //     $this->user = $user;
    //     $this->plan = $plan;
    // }

    public function __construct(protected User $user, protected Plan $plan)
    {
        
    }
}

$user = new User('jone_doe');
// $plan = new Plan('yearly');
$plan = new Plan;

$signup = new Signup($user, $plan);

var_dump($signup);