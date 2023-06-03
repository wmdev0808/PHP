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

- About:

  In the previous episode, we begrudgingly duplicated the same HTML for every PHP view. Let's fix that now by reaching for PHP partials.

- Things You'll Learn

  - Extract Partial
  - Folder Structure

## 14. Superglobals and Current Page Styling

- About

  Often, you'll need to apply styles or trigger certain logic based upon the current page. Luckily, we can use PHP's `$_SERVER` superglobal array to dynamically determine the current page.

- Things You'll Learn

  - Superglobals
  - Ternary Operator
  - var_dump

- Superglobals

  - `Superglobals` — Built-in variables that are always available in all scopes

  - Description

    Several predefined variables in PHP are "superglobals", which means they are available in all scopes throughout a script. There is no need to do `global $variable;` to access them within functions or methods.

    - These superglobal variables are:

      - `$GLOBALS`
      - `$_SERVER`
      - `$_GET`
      - `$_POST`
      - `$_FILES`
      - `$_COOKIE`
      - `$_SESSION`
      - `$_REQUEST`
      - `$_ENV`

- Ternary Operator

  - Another conditional operator is the "?:" (or ternary) operator.

  - **Example #3 Assigning a default value**

    ```php
    <?php
    // Example usage for: Ternary Operator
    $action = (empty($_POST['action'])) ? 'default' : $_POST['action'];

    // The above is identical to this if/else statement
    if (empty($_POST['action'])) {
        $action = 'default';
    } else {
        $action = $_POST['action'];
    }
    ?>
    ```

    - The expression `(expr1) ? (expr2) : (expr3)` evaluates to `expr2` if `expr1` evaluates to `true`, and `expr3` if `expr1` evaluates to `false`.

  - It is possible to leave out the middle part of the ternary operator.

    - Expression `expr1 ?: expr3` evaluates to the result of `expr1` if `expr1` evaluates to `true`, and `expr3` otherwise. `expr1` is only evaluated once in this case.

  - Note: Please note that the `ternary` operator is an expression, and that it doesn't evaluate to a variable, but to the result of an expression. This is important to know if you want to return a variable by reference. The statement return `$var == 42 ? $a : $b;` in a return-by-reference function will therefore not work and a warning is issued.

  - Note:

    It is recommended to avoid "stacking" `ternary` expressions. PHP's behaviour when using more than one unparenthesized `ternary` operator within a single expression is non-obvious compared to other languages. Indeed prior to PHP 8.0.0, `ternary` expressions were evaluated left-associative, instead of right-associative like most other programming languages. Relying on left-associativity is deprecated as of PHP 7.4.0. As of PHP 8.0.0, the `ternary` operator is non-associative.

    - **Example #4 Non-obvious Ternary Behaviour**

      ```php
      <?php
      // on first glance, the following appears to output 'true'
      echo (true ? 'true' : false ? 't' : 'f');

      // however, the actual output of the above is 't' prior to PHP 8.0.0
      // this is because ternary expressions are left-associative

      // the following is a more obvious version of the same code as above
      echo ((true ? 'true' : false) ? 't' : 'f');

      // here, one can see that the first expression is evaluated to 'true', which
      // in turn evaluates to (bool)true, thus returning the true branch of the
      // second ternary expression.
      ?>
      ```

  - Note:

    Chaining of short-ternaries (?:), however, is stable and behaves reasonably. It will evaluate to the first argument that evaluates to a non-falsy value. Note that undefined values will still raise a warning.

    - **Example #5 Short-ternary chaining**

      ```php
      <?php
      echo 0 ?: 1 ?: 2 ?: 3, PHP_EOL; //1
      echo 0 ?: 0 ?: 2 ?: 3, PHP_EOL; //2
      echo 0 ?: 0 ?: 0 ?: 3, PHP_EOL; //3
      ?>
      ```

- `var_dump`

  - (PHP 4, PHP 5, PHP 7, PHP 8)

  - `var_dump` — Dumps information about a variable

  - Description:

    ```php
    var_dump(mixed $value, mixed ...$values): void
    ```

    - This function displays structured information about one or more expressions that includes its type and value. Arrays and objects are explored recursively with values indented to show structure.

    - All public, private and protected properties of objects will be returned in the output unless the object implements a `__debugInfo()` method.

    - Tip:

      As with anything that outputs its result directly to the browser, the output-control functions can be used to capture the output of this function, and save it in a string (for example).

  - Parameters:

    - `value`

      The expression to dump.

    - `values`

      Further expressions to dump.

  - Return Values:

    No value is returned.

  - Examples

    - **Example #1 var_dump() example**

      ```php
      <?php
      $a = array(1, 2, array("a", "b", "c"));
      var_dump($a);
      ?>
      ```

      - The above example will output:

        ```bash
        array(3) {
          [0]=>
          int(1)
          [1]=>
          int(2)
          [2]=>
          array(3) {
            [0]=>
            string(1) "a"
            [1]=>
            string(1) "b"
            [2]=>
            string(1) "c"
          }
        }
        ```

      ```php
      <?php

      $b = 3.1;
      $c = true;
      var_dump($b, $c);

      ?>
      ```

      - The above example will output:

        ```bash
        float(3.1)
        bool(true)
        ```

## 15. Make a PHP Router

- About

  I think your PHP skills have now matured to the point that you're ready to build a custom PHP router from scratch. This will give us the chance to discuss code organization, response codes, and more.

- Things You'll Learn

  - Routers
  - Status Code
  - Code Organization

- Status Code

  - `http_response_code`

    - (PHP 5 >= 5.4.0, PHP 7, PHP 8)

    - `http_response_code` — Get or Set the HTTP response code

    - Description ¶

      ```php
      http_response_code(int $response_code = 0): int|bool
      ```

      - Gets or sets the HTTP response status code.

    - Parameters ¶

      - `response_code`

        - The optional `response_code` will set the response code.

    - Return Values ¶

      - If `response_code` is provided, then the previous status code will be returned. If `response_code` is not provided, then the current status code will be returned. Both of these values will default to a 200 status code if used in a web server environment.

      - `false` will be returned if `response_code` is not provided and it is not invoked in a web server environment (such as from a CLI application).
      - `true` will be returned if `response_code` is provided and it is not invoked in a web server environment (but only when no previous response status has been set).

    - Examples

      - **Example #1 Using http_response_code() in a web server environment**

        ```php
        <?php

        // Get the current response code and set a new one
        var_dump(http_response_code(404));

        // Get the new response code
        var_dump(http_response_code());
        ?>
        ```

        - The above example will output:

          ```bash
          int(200)
          int(404)
          ```

      - **Example #2 Using http_response_code() in a CLI environment**

        ```php
        <?php

        // Get the current default response code
        var_dump(http_response_code());

        // Set a response code
        var_dump(http_response_code(201));

        // Get the new response code
        var_dump(http_response_code());
        ?>
        ```

        - The above example will output:

          ```bash
          bool(false)
          bool(true)
          int(201)
          ```

      - If your version of PHP does not include this function:

        ```php
        <?php

        if (!function_exists('http_response_code')) {
            function http_response_code($code = NULL) {

                if ($code !== NULL) {

                    switch ($code) {
                        case 100: $text = 'Continue'; break;
                        case 101: $text = 'Switching Protocols'; break;
                        case 200: $text = 'OK'; break;
                        case 201: $text = 'Created'; break;
                        case 202: $text = 'Accepted'; break;
                        case 203: $text = 'Non-Authoritative Information'; break;
                        case 204: $text = 'No Content'; break;
                        case 205: $text = 'Reset Content'; break;
                        case 206: $text = 'Partial Content'; break;
                        case 300: $text = 'Multiple Choices'; break;
                        case 301: $text = 'Moved Permanently'; break;
                        case 302: $text = 'Moved Temporarily'; break;
                        case 303: $text = 'See Other'; break;
                        case 304: $text = 'Not Modified'; break;
                        case 305: $text = 'Use Proxy'; break;
                        case 400: $text = 'Bad Request'; break;
                        case 401: $text = 'Unauthorized'; break;
                        case 402: $text = 'Payment Required'; break;
                        case 403: $text = 'Forbidden'; break;
                        case 404: $text = 'Not Found'; break;
                        case 405: $text = 'Method Not Allowed'; break;
                        case 406: $text = 'Not Acceptable'; break;
                        case 407: $text = 'Proxy Authentication Required'; break;
                        case 408: $text = 'Request Time-out'; break;
                        case 409: $text = 'Conflict'; break;
                        case 410: $text = 'Gone'; break;
                        case 411: $text = 'Length Required'; break;
                        case 412: $text = 'Precondition Failed'; break;
                        case 413: $text = 'Request Entity Too Large'; break;
                        case 414: $text = 'Request-URI Too Large'; break;
                        case 415: $text = 'Unsupported Media Type'; break;
                        case 500: $text = 'Internal Server Error'; break;
                        case 501: $text = 'Not Implemented'; break;
                        case 502: $text = 'Bad Gateway'; break;
                        case 503: $text = 'Service Unavailable'; break;
                        case 504: $text = 'Gateway Time-out'; break;
                        case 505: $text = 'HTTP Version not supported'; break;
                        default:
                            exit('Unknown http status code "' . htmlentities($code) . '"');
                        break;
                    }

                    $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

                    header($protocol . ' ' . $code . ' ' . $text);

                    $GLOBALS['http_response_code'] = $code;

                } else {

                    $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

                }

                return $code;

            }
        }

        ?>
        ```

- require

  - (PHP 4, PHP 5, PHP 7, PHP 8)

  - `require` is identical to `include` except upon failure it will also produce a fatal `E_COMPILE_ERROR` level error. In other words, it will halt the script whereas `include` only emits a warning (`E_WARNING`) which allows the script to continue.

  - Example

    - Remember, when using require that it is a statement, not a function. It's not necessary to write:

    ```php
    <?php
    require('somefile.php');
    ?>

    The following:
    <?php
    require 'somefile.php';
    ?>
    ```

    - Is preferred, it will prevent your peers from giving you a hard time and a trivial conversation about what require really is.

- die

  - (PHP 4, PHP 5, PHP 7, PHP 8)

  - die — Equivalent to exit

  - Description ¶

    - This language construct is equivalent to `exit()`.

  - Note:

    - It is poor design to rely on die() for error handling in a web site because it results in an ugly experience for site users: a broken page and - if they're lucky - an error message that is no help to them at all. As far as they are concerned, when the page breaks, the whole site might as well be broken.

    - If you ever want the public to use your site, always design it to handle errors in a way that will allow them to continue using it if possible. If it's not possible and the site really is broken, make sure that you find out so that you can fix it. die() by itself won't do either.

    - If a supermarket freezer breaks down, a customer who wanted to buy a tub of ice cream doesn't expect to be kicked out of the building.

- exit

  - (PHP 4, PHP 5, PHP 7, PHP 8)

  - exit — Output a message and terminate the current script

  - Description ¶

    ```php
    exit(string $status = ?): void

    exit(int $status): void
    ```

    - Terminates execution of the script. `Shutdown functions` and `object destructors` will always be executed even if exit is called.

    - `exit` is a language construct and it can be called without parentheses if no `status` is passed.

  - Parameters ¶

    - status

      - If `status` is a string, this function prints the `status` just before exiting.

      - If `status` is an int, that value will be used as the exit status and not printed. Exit statuses should be in the range 0 to 254, the exit status 255 is reserved by PHP and shall not be used. The status 0 is used to terminate the program successfully.

  - Return Values ¶

    - No value is returned.

  - Examples ¶

    - **Example #1 exit example**

      ```php
      <?php

      $filename = '/path/to/data-file';
      $file = fopen($filename, 'r')
          or exit("unable to open file ($filename)");

      ?>
      ```

    - **Example #2 exit status example**

      ```php
      <?php

      //exit program normally
      exit;
      exit();
      exit(0);

      //exit with an error code
      exit(1);
      exit(0376); //octal

      ?>
      ```

    - **Example #3 Shutdown functions and destructors run regardless**

      ```php
      <?php
      class Foo
      {
          public function __destruct()
          {
              echo 'Destruct: ' . __METHOD__ . '()' . PHP_EOL;
          }
      }

      function shutdown()
      {
          echo 'Shutdown: ' . __FUNCTION__ . '()' . PHP_EOL;
      }

      $foo = new Foo();
      register_shutdown_function('shutdown');

      exit();
      echo 'This will not be output.';
      ?>
      ```

      - The above example will output:

        ```bash
        Shutdown: shutdown()
        Destruct: Foo::__destruct()
        ```

  - Notes ¶

    - Note: Because this is a language construct and not a function, it cannot be called using `variable functions`, or `named arguments`.

    - Note:

      - This language construct is equivalent to die().

  - User Contributed Notes

    - If you want to avoid calling `exit()` in FastCGI as per the comments below, but really, positively want to exit cleanly from nested function call or include, consider doing it the Python way:

      - define an exception named `SystemExit`, throw it instead of calling `exit()` and catch it in index.php with an empty handler to finish script execution cleanly.

      ```php
      <?php

      // file: index.php
      class SystemExit extends Exception {}
      try {
        /* code code */
      }
      catch (SystemExit $e) { /* do nothing */ }
      // end of file: index.php

      // some deeply nested function or .php file

      if (SOME_EXIT_CONDITION)
        throw new SystemExit(); // instead of exit()

      ?>
      ```

    - 2

      ```php
      <?php

      if($_SERVER['SCRIPT_FILENAME'] == __FILE__ )
        header('Location: /');

      ?>
      ```

      - After sending the `Location:` header PHP _will_ continue parsing, and all code below the header() call will still be executed. So instead use:

        ```php
        <?php

        if($_SERVER['SCRIPT_FILENAME'] == __FILE__)
        {
          header('Location: /');
          exit;
        }
        ?>
        ```

- Variable functions

  - PHP supports the concept of variable functions. This means that if a variable name has parentheses appended to it, PHP will look for a function with the same name as whatever the variable evaluates to, and will attempt to execute it. Among other things, this can be used to implement callbacks, function tables, and so forth.

  - Variable functions won't work with language constructs such as `echo`, `print`, `unset()`, `isset(`), `empty()`, `include`, `require` and the like. Utilize wrapper functions to make use of any of these constructs as variable functions.

  - **Example #1 Variable function example**

    ```php
    <?php
    function foo() {
        echo "In foo()<br />\n";
    }

    function bar($arg = '')
    {
        echo "In bar(); argument was '$arg'.<br />\n";
    }

    // This is a wrapper function around echo
    function echoit($string)
    {
        echo $string;
    }

    $func = 'foo';
    $func();        // This calls foo()

    $func = 'bar';
    $func('test');  // This calls bar()

    $func = 'echoit';
    $func('test');  // This calls echoit()
    ?>
    ```

  - **Example #2 Variable method example**

    ```php
    <?php
    class Foo
    {
        function Variable()
        {
            $name = 'Bar';
            $this->$name(); // This calls the Bar() method
        }

        function Bar()
        {
            echo "This is Bar";
        }
    }

    $foo = new Foo();
    $funcname = "Variable";
    $foo->$funcname();  // This calls $foo->Variable()

    ?>
    ```

    - When calling static methods, the function call is stronger than the static property operator:

  - **Example #3 Variable method example with static properties**

    ```php
    <?php
    class Foo
    {
        static $variable = 'static property';
        static function Variable()
        {
            echo 'Method Variable called';
        }
    }

    echo Foo::$variable; // This prints 'static property'. It does need a $variable in this scope.
    $variable = "Variable";
    Foo::$variable();  // This calls $foo->Variable() reading $variable in this scope.

    ?>
    ```

  - **Example #4 Complex callables**

    ```php
    <?php
    class Foo
    {
        static function bar()
        {
            echo "bar\n";
        }
        function baz()
        {
            echo "baz\n";
        }
    }

    $func = array("Foo", "bar");
    $func(); // prints "bar"
    $func = array(new Foo, "baz");
    $func(); // prints "baz"
    $func = "Foo::bar";
    $func(); // prints "bar"
    ?>
    ```

- Named Arguments

  - PHP 8.0.0 introduced named arguments as an extension of the existing positional parameters. Named arguments allow passing arguments to a function based on the parameter name, rather than the parameter position. This makes the meaning of the argument self-documenting, makes the arguments order-independent and allows skipping default values arbitrarily.

  - Named arguments are passed by prefixing the value with the parameter name followed by a colon. Using reserved keywords as parameter names is allowed. The parameter name must be an identifier, specifying dynamically is not allowed.

  - **Example #15 Named argument syntax**

    ```php
    <?php
    myFunction(paramName: $value);
    array_foobar(array: $value);

    // NOT supported.
    function_name($variableStoringParamName: $value);
    ?>
    ```

  - **Example #16 Positional arguments versus named arguments**

    ```php
    <?php
    // Using positional arguments:
    array_fill(0, 100, 50);

    // Using named arguments:
    array_fill(start_index: 0, count: 100, value: 50);
    ?>
    ```

    - The order in which the named arguments are passed does not matter.

  - **Example #17 Same example as above with a different order of parameters**

    ```php
    <?php
    array_fill(value: 50, count: 100, start_index: 0);
    ?>
    ```

  - Named arguments can be combined with positional arguments. In this case, the named arguments must come after the positional arguments. It is also possible to specify only some of the optional arguments of a function, regardless of their order.

  - **Example #18 Combining named arguments with positional arguments**

    ```php
    <?php
    htmlspecialchars($string, double_encode: false);
    // Same as
    htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8', false);
    ?>
    ```

  - Passing the same parameter multiple times results in an Error exception.

  - **Example #19 Error thrown when passing the same parameter multiple times**

    ```php
    <?php
    function foo($param) { ... }

    foo(param: 1, param: 2);
    // Error: Named parameter $param overwrites previous argument
    foo(1, param: 2);
    // Error: Named parameter $param overwrites previous argument
    ?>
    ```

  - As of PHP 8.1.0, it is possible to use named arguments after unpacking the arguments. A named argument must not override an already unpacked arguments.

  - **Example #20 Use named arguments after unpacking**

    ```php
    <?php
    function foo($a, $b, $c = 3, $d = 4) {
      return $a + $b + $c + $d;
    }

    var_dump(foo(...[1, 2], d: 40)); // 46
    var_dump(foo(...['b' => 2, 'a' => 1], d: 40)); // 46

    var_dump(foo(...[1, 2], b: 20)); // Fatal error. Named parameter $b overwrites previous argument
    ?>
    ```

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
