# 1. The Fundamentals

## 1. How to Choose a Programming Language

## 2. Tools of the Trade

## 3. Your First PHP Tag

- About
  Our first order of business is to prepare some basic HTML, boot a PHP server, and view it in the browser.

- Things You'll Learn

  - PHP Tags
  - Strings
  - echo

- Homework

  Create a paragraph that uses PHP to echo any basic sentence of your choosing. Practice typing the opening and closing <?php tags.

## 4. Variables

- About

  Okay, let's move on and review basic concatenation and variables. The first time I learned about variables, my first thought was, "But why?". Let's talk about it!

- Things You'll Learn

  - Concatenation
  - Variables

- Homework

  Now that `$greeting` is a variable, do the same for the `noun` ("World"). Then play around with changing the variable values to generate different sentences.

- A variable inside single quote is not evaluated

  ```php
  <?php
    $greeting = "Hello";

    echo '$greeting Everybody!' // Output: $greeting Everybody!
  ?>
  ```

- If you want to evaluate an variable inside string, use double quote(`"`):

  ```php
  <?php
    $greeting = "Hello";

    echo "$greeting Everybody!";
  ```

## 5. Conditionals and Booleans

- About

  For this next episode, we'll build a quick webpage that displays a dynamic message based upon whether or not you've read a particular book. This will give us the opportunity to review both conditionals and booleans.

- Things You'll Learn

  - Conditionals
  - Booleans
  - Short Echo Tags

- Homework
  Use a PHP short echo tag to display the string, "Hello World" on the page.

## 6. Arrays

- About

  At this point, you know how to create a variable for a primitive string or number. But what about situations when we want to declare a collection, or list of things? A list of usernames, or book titles, or tweets? In these situations, we can reach for arrays.

- Things You'll Learn

  - Arrays
  - Foreach
  - Alternative Syntax

- Foreach

  - Syntax:

    ```php
    foreach (iterable_expression as $value)
        statement
    foreach (iterable_expression as $key => $value)
        statement
    ```

  - In order to be able to directly modify array elements within the loop precede `$value` with `&`. In that case the value will be assigned by reference.

    ```php
    <?php
    $arr = array(1, 2, 3, 4);
    foreach ($arr as &$value) {
        $value = $value * 2;
    }
    // $arr is now array(2, 4, 6, 8)
    unset($value); // break the reference with the last element
    ?>
    ```

  - **Warning**

    Reference of a `$value` and the last array element remain even after the foreach loop. It is recommended to destroy it by `unset()`. Otherwise you will experience the following behavior:

    ```php
    <?php
    $arr = array(1, 2, 3, 4);
    foreach ($arr as &$value) {
        $value = $value * 2;
    }
    // $arr is now array(2, 4, 6, 8)

    // without an unset($value), $value is still a reference to the last item: $arr[3]

    foreach ($arr as $key => $value) {
        // $arr[3] will be updated with each value from $arr...
        echo "{$key} => {$value} ";
        print_r($arr);
    }
    // ...until ultimately the second-to-last value is copied onto the last value

    // output:
    // 0 => 2 Array ( [0] => 2, [1] => 4, [2] => 6, [3] => 2 )
    // 1 => 4 Array ( [0] => 2, [1] => 4, [2] => 6, [3] => 4 )
    // 2 => 6 Array ( [0] => 2, [1] => 4, [2] => 6, [3] => 6 )
    // 3 => 6 Array ( [0] => 2, [1] => 4, [2] => 6, [3] => 6 )
    ?>
    ```

  - It is possible to iterate a constant array's value by reference:

    ```php
    <?php
    foreach (array(1, 2, 3, 4) as &$value) {
        $value = $value * 2;
    }
    ?>
    ```

- Homework

  Create an array of any three usernames - perhaps for a "Top Performing Users" section of your website. Then, create a loop that displays each username within a list item.

## 7. Associative Arrays

- About

  Let's stick with arrays just a little longer. In this episode, you'll learn the syntax for accessing individual items within an array. You'll also learn about associative arrays, which allow you to associate a key with each value.

- Things You'll Learn

  - Array Access
  - Key-Value Pairs
  - Data

- Homework

  Extend the book list from this episode's example to also include and display the release year immediately after the book's title.

## 8. Functions and Filters

- About

  Congratulations for making it this far! Let's take things a step further now and review functions. You can think of functions as the verbs of the programming world.

- Things You'll Learn

  - Functions
  - Array Filtering
  - Checking for Equality

- Homework

  Create an array of your favorites movies, including their respective release dates. Then, write a function that filters your list of movies down to only those that were released in the year 2000 or higher. Display the results in an unordered list.

## 9. Lambda Functions

- About

  Buckle up, because we have a lot to cover in this episode! As part of our first code refactor, we'll discuss what lambda functions are, as well as when and why you might reach for them.

  ```php
  function filter($items, $fn) // $fn: anonymous function is called a lambda
  {
    $filteredItems = [];

    foreach ($items as $item) {
      if ($fn($item)) {
        $filteredItems[] = $item;
      }
    }

    return $filteredItems;
  }

  $filteredItems = filter($books, function ($book) {
    return $book['releaseYear'] < 2000;
  });
  ```

- **Anonymous functions**

  - Anonymous functions, also known as `closures`, allow the creation of functions which have no specified name. They are most useful as the value of `callable` parameters, but they have many other uses.

  - Anonymous functions are implemented using the `Closure` class.

    - **Example #1 Anonymous function example**

      ```php
      <?php
      echo preg_replace_callback('~-([a-z])~', function ($match) {
          return strtoupper($match[1]);
      }, 'hello-world');
      // outputs helloWorld
      ?>
      ```

  - Closures can also be used as the values of variables; PHP automatically converts such expressions into instances of the `Closure` internal class. Assigning a closure to a variable uses the same syntax as any other assignment, including the trailing semicolon:

    - **Example #2 Anonymous function variable assignment example**

      ```php
      <?php
      $greet = function($name) {
          printf("Hello %s\r\n", $name);
      };

      $greet('World');
      $greet('PHP');
      ?>
      ```

  - Closures may also inherit variables from the parent scope. Any such variables must be passed to the use language construct. As of PHP 7.1, these variables must not include `superglobals`, `$this`, or variables with the same name as a parameter. A return type declaration of the function has to be placed after the use clause.

    - **Example #3 Inheriting variables from the parent scope**

      ```php
      <?php
      $message = 'hello';

      // No "use"
      $example = function () {
          var_dump($message);
      };
      $example();

      // Inherit $message
      $example = function () use ($message) {
          var_dump($message);
      };
      $example();

      // Inherited variable's value is from when the function
      // is defined, not when called
      $message = 'world';
      $example();

      // Reset message
      $message = 'hello';

      // Inherit by-reference
      $example = function () use (&$message) {
          var_dump($message);
      };
      $example();

      // The changed value in the parent scope
      // is reflected inside the function call
      $message = 'world';
      $example();

      // Closures can also accept regular arguments
      $example = function ($arg) use ($message) {
          var_dump($arg . ' ' . $message);
      };
      $example("hello");

      // Return type declaration comes after the use clause
      $example = function () use ($message): string {
          return "hello $message";
      };
      var_dump($example());
      ?>
      ```

    - The above example will output something similar to:

      ```bash
      Notice: Undefined variable: message in /example.php on line 6
      NULL
      string(5) "hello"
      string(5) "hello"
      string(5) "hello"
      string(5) "world"
      string(11) "hello world"
      string(11) "hello world"
      ```

    - As of PHP 8.0.0, the list of scope-inherited variables may include a trailing comma, which will be ignored.

  - Inheriting variables from the parent scope is not the same as using global variables. Global variables exist in the global scope, which is the same no matter what function is executing. The parent scope of a closure is the function in which the closure was declared (not necessarily the function it was called from). See the following example:

    - **Example #4 Closures and scoping**

      ```php
      <?php
      // A basic shopping cart which contains a list of added products
      // and the quantity of each product. Includes a method which
      // calculates the total price of the items in the cart using a
      // closure as a callback.
      class Cart
      {
          const PRICE_BUTTER  = 1.00;
          const PRICE_MILK    = 3.00;
          const PRICE_EGGS    = 6.95;

          protected $products = array();

          public function add($product, $quantity)
          {
              $this->products[$product] = $quantity;
          }

          public function getQuantity($product)
          {
              return isset($this->products[$product]) ? $this->products[$product] :
                    FALSE;
          }

          public function getTotal($tax)
          {
              $total = 0.00;

              $callback =
                  function ($quantity, $product) use ($tax, &$total)
                  {
                      $pricePerItem = constant(__CLASS__ . "::PRICE_" .
                          strtoupper($product));
                      $total += ($pricePerItem * $quantity) * ($tax + 1.0);
                  };

              array_walk($this->products, $callback);
              return round($total, 2);
          }
      }

      $my_cart = new Cart;

      // Add some items to the cart
      $my_cart->add('butter', 1);
      $my_cart->add('milk', 3);
      $my_cart->add('eggs', 6);

      // Print the total with a 5% sales tax.
      print $my_cart->getTotal(0.05) . "\n";
      // The result is 54.29
      ?>
      ```

    - Example #5 Automatic binding of $this

      ```php
      <?php

      class Test
      {
          public function testing()
          {
              return function() {
                  var_dump($this);
              };
          }
      }

      $object = new Test;
      $function = $object->testing();
      $function();

      ?>
      ```

    - The above example will output:

      ```bash
      object(Test)#1 (0) {
      }
      ```

    - When declared in the context of a class, the current class is automatically bound to it, making $this available inside of the function's scope. If this automatic binding of the current class is not wanted, then `static anonymous functions` may be used instead.

- **Static anonymous functions**

  - Anonymous functions may be declared statically. This prevents them from having the current class automatically bound to them. Objects may also not be bound to them at runtime.

  - **Example #6 Attempting to use $this inside a static anonymous function**

    ```php
    <?php

    class Foo
    {
        function __construct()
        {
            $func = static function() {
                var_dump($this);
            };
            $func();
        }
    };
    new Foo();

    ?>
    ```

    - The above example will output:

      ```bash
      Notice: Undefined variable: this in %s on line %d
      NULL
      ```

  - **Example #7 Attempting to bind an object to a static anonymous function**

    ```php
    <?php

    $func = static function() {
        // function body
    };
    $func = $func->bindTo(new stdClass);
    $func();

    ?>
    ```

    - The above example will output:

      ```bash
      Warning: Cannot bind an instance to a static closure in %s on line %d
      ```

- Things You'll Learn

  - Lambdas
  - Extract Variable
  - array_filter

- Homework

  Update your book filtering logic from this episode to only display books that were first published between the years 1950 and 2020. Hint - the PHP equivalent of "and" is `&&`.

## 10. Separate Logic From the Template

- About

  Before we move on to the technical check-in for this chapter, let's set aside a bit of time to discuss code organization and why we might want to separate our PHP logic from the view, or HTML.

- Things You'll Learn
  - Code Organization
  - Logic Separation
  - require and include

## 11. Technical Check-in #1(With Quiz)

- About

  Before we move on to section two, let's do a quick technical check-in to ensure that everything you've learned so far has been committed to memory. And don't forget to complete the quiz before continuing.

- Things You'll Learn

  - Variables
  - Conditionals
  - Loops
  - Functions

- **PHP for Beginners: Check-In #1**

  - Quesiton 1

    Which character is required at the beginning of any PHP variable?

    ```php
    // Example
    ...name = "Joe";
    ```

    - [ ] A: `%`
    - [x] B: `$`
    - [ ] C: `*`
    - [ ] D: `@`

  - Question 2:

    To render a string on the page, which PHP keyword might we use?

    ```php
    ... "Hello World";
    ```

    - [ ] A: `display`
    - [ ] B: `show`
    - [ ] C: `put`
    - [x] D: `echo`

  - Question 3

    What is the correct syntax for creating a list of, say, popular baby names?

    ```php
    $popularNames = ...;
    ```

    - [ ] A:

      ```php
      {'Oliver', 'Violet', 'Noah', 'Aurora'}
      ```

    - [ ] B:

      ```php
      ['Oliver' 'Violet' 'Noah' 'Aurora']
      ```

    - [ ] C:

      ```php
      Arrizay('Oliver', 'Violet', 'Noah', 'Aurora')
      ```

    - [x] D:

      ```php
      ['Oliver', 'Violet', 'Noah', 'Aurora']
      ```

  - Question 4

    True or False: Arrays can optionally include keys.

    - [x] A: True

    - [ ] B: False

  - Question 5

    Which of the following will correctly create the attributes for a blog post?

    ```php
    $post = ...;
    ```

    - [ ] A:

      ```php
      [ 'title': 'My Blog Post', 'author': 'LaryRobot' ]
      ```

    - [x] B:

      ```php
      [ 'title' => 'My Blog Post', 'author' => 'LaryRobot' ]
      ```

    - [ ] C:

      ```php
      [ title => My Blog Post, author => LaryRobot ]
      ```

    - [ ] D:

      ```php
      [ title: 'My Blog Post', author: 'LaryRobot' ]
      ```

  - Question 6

    How might we check if the appointment has NOT been confirmed?

    ```php
    $confirmed = false;

    if (...) {
      echo 'This appointment has not yet been confirmed.';
    }
    ```

    - [ ] A:

      ```php
      $confirmed
      ```

    - [x] B:

      ```php
      !$confirmed
      ```

    - [ ] C:

      ```php
      is not $confirmed
      ```

    - [ ] D:

      ```php
      !!$confirmed
      ```

  - Question 7

    Which keyword might we use to loop over a list of books?

    ```php
    $books = ['Frankenstein', 'Animal Farm', '1984'];

    ... ($books as $book) {
        echo $book;
    }
    ```

    - [x] A: `foreach`

    - [ ] B: `for each`

    - [ ] C: `iterate`

    - [ ] D: `loop`

  - Question 8

    If a function should return a value, which keyword should we use?

    ```php
    function greet($thing) {
      ... "Hello there, {$thing}";
    }
    ```

    - [ ] A: send

    - [ ] B: respond

    - [x] C: return

    - [ ] D: back

  - Question 9

    What might we call a function that does not have a name?

    ```php
    // Example of an ... function.
    $isAdult = function ($person) {
      return $person['age'] >= 18;
    }

    $adults = array_filter($people, $isAdult);
    ```

    - [ ] A: invalid

    - [ ] B: unnamed

    - [ ] C: unassigned

    - [x] D: anonymous

  - Question 10

    What is the correct way to determine equality?

    ```php
      function isManager($person) {
        return $person['role'] ... 'Manager';
      }
    ```

    - [ ] A: =

    - [x] B: ===

    - [ ] C: <===>

    - [ ] D: equals

# 2. Dynamic Web Applications

## 12. Page Links

- About

  Welcome to section two! While section one focused entirely on the initial fundamentals of PHP, now, we'll move on and learn what it looks like to build a typical PHP application with a MySQL database.

- Things You'll Learn

  - Page Linking
  - Templates
  - TailwindCSS

- TailwindCSS

  - References:

    - Tailwind CSS:

      https://tailwindcss.com/

    - Tailwind UI:

      https://tailwindui.com/

  - We'll use a Tailwind CSS UI Component, `Stacked Layouts - Dark nav with white page header` at https://tailwindui.com/components/application-ui/application-shells/stacked

- Homework

  Create a fourth page, called "Our Mission," and link to it from your navigation menu.

## 13. PHP Partials

## 14. Superglobals and Current Page Styling

## 15. Make a PHP Router

## 16. Create a MySQL Database

## 17. PDO First Steps

## 18. Extract a PHP Database Class

## 19. Environments and Configuration Flexibility

## 20. SQL Injection Vulnerabilities Explained

# 3. Notes Mini-Project

## 21. Database Tables and Indexes

## 22. Render the Notes and Note Page

## 23. Introduction to Authorization

## 24. Programming is Rewriting

## 25. Intro to Forms and Request Methods

## 26. Always Escape Untrusted Input

## 27. Intro to Form Validation

## 28. Extract a Simple Validator Class

# 4. Project Organization

## 29. Resourceful Naming Conventions

## 30. PHP Autoloading and Extraction

## 31. Namespacing: What, Why, How?

## 32. Handle Multiple Request Methods From a Controller Action?

## 33. Build a Better Router

## 34. One Request, One Controller

## 35. Make Your First Service Container

## 36. Updating With PATCH Requests

# 5. Sessions and Authentication

## 37. PHP Sessions 101

## 38. Register a New User

## 39. Introduction to Middleware

## 40. Manage Passwords Like This For The Remainder of Your Career

## 41. Log In and Log Out

# 6. Refactoring Techniques

## 42. Extract a Form Validation Object

## 43. Extract an Authenticator Class

## 44. The PRG Pattern (and Session Flashing)

## 45. Flash Old Form Data to the Session

## 46. Automatically Redirect Back Upon Failed Validation

# 7. Meet Composer

## 47. Composer and Free Autoloading

## 48. Install Two Composer Packages: Collections and PestPHP
