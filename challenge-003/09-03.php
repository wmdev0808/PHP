<?php declare(strict_types=1);

// class User 
// {
//     public function cancel(bool $immediate = false)
//     {
//         var_dump($immediate);
//     }
// }

// $joe = new User;

// $joe->cancel();
// $joe->cancel(true);
// $joe->cancel(false);

// $joe->cancel('next week'); // PHP Fatal error in strict_type mode


// To solve this, we can use Union type
class User 
{
    public function cancel(bool|string $immediate = false)
    {
        var_dump($immediate);
    }

    public function cancelNow()
    {
        $this->cancel(true);
    }

    public function cancelOn(string|DateTime $when)
    {
        $this->cancel($when);
    }
}

$joe = new User;

$joe->cancel();
// These true, false arguments are confusing
// $joe->cancel(true);
// $joe->cancel(false);
// $joe->cancelOn('next week'); // string(9) "next week", No errors

$joe->cancelNow();
$joe->cancelOn('Thursday'); 