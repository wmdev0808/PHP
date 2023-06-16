<?php

class Invoice 
{
    // private $description;
    // private $total;
    // private $date;
    // private $paid;

    // public function __construct($description, $total, $date, $paid)
    // {
    //     $this->description = $description;
    //     $this->total = $total;
    //     $this->date = $date;
    //     $this->paid = $paid;
    // }

    public function __construct(
        private $description, 
        private $total, 
        private $date, 
        private $paid)
    {
        
    }
}

// $invoice = new Invoice(
//     'Customer installation',
//     10000,
//     new DateTime(),
//     true
// );

$invoice = new Invoice(
    paid: true,
    description: 'Customer installation',
    total: 10000,
    date: new DateTime()    
);

var_dump($invoice);