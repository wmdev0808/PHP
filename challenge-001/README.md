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

- About

  - We're now ready to begin interacting with a MySQL database. Before we write any PHP, let's first review how to connect to MySQL, and then create a database and table.

- Things You'll Learn

  - Databases
  - Tables
  - Columns

- Homework

  Play around with the `TablePlus` UI and become comfortable with creating tables, adding columns, and applying changes.

## 17. PDO First Steps

- About

  The next step on our journey is to figure out how to connect to MySQL from PHP and execute a simple SELECT query. We'll of course reach for PHP Data Objects, or PDO, to orchestrate this task securely.

- Things You'll Learn

  - Select Queries
  - DSNs
  - PDO

- Homework

  Create a prepared statement to fetch the post that has an id of 1. Then, experiment with calling `fetch()` instead of `fetchAll()`. How is the output different?

- PDO

  - The PHP Data Objects (PDO) extension defines a lightweight, consistent interface for accessing databases in PHP. Each database driver that implements the PDO interface can expose database-specific features as regular extension functions. Note that you cannot perform any database functions using the PDO extension by itself; you must use a `database-specific PDO driver` to access a database server.

  - PDO provides a data-access abstraction layer, which means that, regardless of which database you're using, you use the same functions to issue queries and fetch data. PDO does not provide a database abstraction; it doesn't rewrite SQL or emulate missing features. You should use a full-blown abstraction layer if you need that facility.

  - PDO ships with PHP.

- PDO_MYSQL DSN

  - (PECL PDO_MYSQL >= 0.1.0)

  - PDO_MYSQL DSN — Connecting to MySQL databases

  - Description ¶

    The PDO_MYSQL Data Source Name (DSN) is composed of the following elements:

    - DSN prefix

      - The DSN prefix is `mysql:`.

    - host

      - The hostname on which the database server resides.

    - port

      - The port number where the database server is listening.

    - dbname

      - The name of the database.

    - unix_socket

      - The MySQL Unix socket (shouldn't be used with `host` or `port`).

    - charset
      - The character set. See the [character set](https://www.php.net/manual/en/mysqlinfo.concepts.charset.php) concepts documentation for more information.

  - Examples ¶

    - **Example #1 PDO_MYSQL DSN examples**

      - The following example shows a `PDO_MYSQL` DSN for connecting to MySQL databases:

        ```bash
        mysql:host=localhost;dbname=testdb
        ```

      - More complete examples:

        ```bash
        mysql:host=localhost;port=3307;dbname=testdb
        mysql:unix_socket=/tmp/mysql.sock;dbname=testdb
        ```

- **What is PECL?**

  - The PHP Extension Community Library

  - PECL is a repository for PHP Extensions, providing a directory of all known extensions and hosting facilities for downloading and development of PHP extensions.

  - The packaging and distribution system used by PECL is shared with its sister, `PEAR`.

- **What is PEAR?**

  - PEAR is short for "PHP Extension and Application Repository" and is pronounced just like the fruit. The purpose of PEAR is to provide:

    - A structured library of open-source code for PHP users
    - A system for code distribution and package maintenance
    - A standard style for code written in PHP, specified here
    - The PHP Extension Community Library (PECL), see more below
    - A web site, mailing lists and download mirrors to support the PHP/PEAR community

## 18. Extract a PHP Database Class

- About

  Now that we understand the basic logic for initializing a PDO instance and executing a prepared query, let's clean things up a bit by extracting a dedicated `Database` class.

- Things You'll Learn

  - Classes
  - Constructor Functions
  - Database Connections

- Class

  - Basic class definitions begin with the keyword `class`, followed by a class name, followed by a pair of curly braces which enclose the definitions of the properties and methods belonging to the class.

  - The class name can be any valid label, provided it is not a PHP [reserved word](https://www.php.net/manual/en/reserved.php). A valid class name starts with a letter or underscore, followed by any number of letters, numbers, or underscores. As a regular expression, it would be expressed thus: `^[a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*$`.

  - A class may contain its own [constants](https://www.php.net/manual/en/language.oop5.constants.php), [variables](https://www.php.net/manual/en/language.oop5.properties.php) (called "properties"), and functions (called "methods").

  - **Example #1 Simple Class definition**

    ```php
    <?php
    class SimpleClass
    {
        // property declaration
        public $var = 'a default value';

        // method declaration
        public function displayVar() {
            echo $this->var;
        }
    }
    ?>
    ```

    - The pseudo-variable `$this` is available when a method is called from within an object context. `$this` is the value of the calling object.

  - **Warning**
    Calling a non-static method statically throws an [Error](https://www.php.net/manual/en/class.error.php). Prior to PHP 8.0.0, this would generate a deprecation notice, and `$this` would be undefined.

    - **Example #2 Some examples of the $this pseudo-variable**

      ```php
      <?php
      class A
      {
          function foo()
          {
              if (isset($this)) {
                  echo '$this is defined (';
                  echo get_class($this);
                  echo ")\n";
              } else {
                  echo "\$this is not defined.\n";
              }
          }
      }

      class B
      {
          function bar()
          {
              A::foo();
          }
      }

      $a = new A();
      $a->foo();

      A::foo();

      $b = new B();
      $b->bar();

      B::bar();
      ?>
      ```

      - Output of the above example in PHP 7:

        ```bash
        $this is defined (A)

        Deprecated: Non-static method A::foo() should not be called statically in %s  on line 27
        $this is not defined.

        Deprecated: Non-static method A::foo() should not be called statically in %s  on line 20
        $this is not defined.

        Deprecated: Non-static method B::bar() should not be called statically in %s  on line 32

        Deprecated: Non-static method A::foo() should not be called statically in %s  on line 20
        $this is not defined.
        ```

      - Output of the above example in PHP 8:

        ```bash
        $this is defined (A)

        Fatal error: Uncaught Error: Non-static method A::foo() cannot be called statically in %s :27
        Stack trace:
        #0 {main}
          thrown in %s  on line 27
        ```

- Constructor

  ```php
  __construct(mixed ...$values = ""): void
  ```

  - PHP allows developers to declare constructor methods for classes. Classes which have a constructor method call this method on each newly-created object, so it is suitable for any initialization that the object may need before it is used.

  - **Note**: Parent constructors are not called implicitly if the child class defines a constructor. In order to run a parent constructor, a call to `parent::__construct()` within the child constructor is required. If the child does not define a constructor then it may be inherited from the parent class just like a normal class method (if it was not declared as private).

  - **Example #1 Constructors in inheritance**

    ```php
    <?php
    class BaseClass {
        function __construct() {
            print "In BaseClass constructor\n";
        }
    }

    class SubClass extends BaseClass {
        function __construct() {
            parent::__construct();
            print "In SubClass constructor\n";
        }
    }

    class OtherSubClass extends BaseClass {
        // inherits BaseClass's constructor
    }

    // In BaseClass constructor
    $obj = new BaseClass();

    // In BaseClass constructor
    // In SubClass constructor
    $obj = new SubClass();

    // In BaseClass constructor
    $obj = new OtherSubClass();
    ?>
    ```

  - Unlike other methods, `__construct()` is exempt from the usual [signature compatibility rules](https://www.php.net/manual/en/language.oop5.basic.php#language.oop.lsp) when being extended.

  - Constructors are ordinary methods which are called during the instantiation of their corresponding object. As such, they may define an arbitrary number of arguments, which may be required, may have a type, and may have a default value. Constructor arguments are called by placing the arguments in parentheses after the class name.

  - **Example #2 Using constructor arguments**

    ```php
    <?php
    class Point {
        protected int $x;
        protected int $y;

        public function __construct(int $x, int $y = 0) {
            $this->x = $x;
            $this->y = $y;
        }
    }

    // Pass both parameters.
    $p1 = new Point(4, 5);
    // Pass only the required parameter. $y will take its default value of 0.
    $p2 = new Point(4);
    // With named parameters (as of PHP 8.0):
    $p3 = new Point(y: 5, x: 4);
    ?>
    ```

  - If a class has no constructor, or the constructor has no required arguments, the parentheses may be omitted.

  - Constructor Promotion ¶

    - As of PHP 8.0.0, constructor parameters may also be promoted to correspond to an object property. It is very common for constructor parameters to be assigned to a property in the constructor but otherwise not operated upon. Constructor promotion provides a short-hand for that use case. The example above could be rewritten as the following.

    - **Example #3 Using constructor property promotion**

      ```php
      <?php
      class Point {
          public function __construct(protected int $x, protected int $y = 0) {
          }
      }
      ```

  - New in initializers ¶

    - As of PHP 8.1.0, objects can be used as default parameter values, static variables, and global constants, as well as in attribute arguments. Objects can also be passed to [define()](https://www.php.net/manual/en/function.define.php) now.

    - Note:

      - The use of a dynamic or non-string class name or an anonymous class is not allowed. The use of argument unpacking is not allowed. The use of unsupported expressions as arguments is not allowed.

    - **Example #4 Using new in initializers**

      ```php
      <?php

      // All allowed:
      static $x = new Foo;

      const C = new Foo;

      function test($param = new Foo) {}

      #[AnAttribute(new Foo)]
      class Test {
          public function __construct(
              public $prop = new Foo,
          ) {}
      }

      // All not allowed (compile-time error):
      function test(
          $a = new (CLASS_NAME_CONSTANT)(), // dynamic class name
          $b = new class {}, // anonymous class
          $c = new A(...[]), // argument unpacking
          $d = new B($abc), // unsupported constant expression
      ) {}
      ?>
      ```

  - Static creation methods ¶

    - PHP only supports a single constructor per class. In some cases, however, it may be desirable to allow an object to be constructed in different ways with different inputs. The recommended way to do so is by using static methods as constructor wrappers.

    - **Example #5 Using static creation methods**

      ```php
      <?php
      class Product {

          private ?int $id;
          private ?string $name;

          private function __construct(?int $id = null, ?string $name = null) {
              $this->id = $id;
              $this->name = $name;
          }

          public static function fromBasicData(int $id, string $name): static {
              $new = new static($id, $name);
              return $new;
          }

          public static function fromJson(string $json): static {
              $data = json_decode($json);
              return new static($data['id'], $data['name']);
          }

          public static function fromXml(string $xml): static {
              // Custom logic here.
              $data = convert_xml_to_array($xml);
              $new = new static();
              $new->id = $data['id'];
              $new->name = $data['name'];
              return $new;
          }
      }

      $p1 = Product::fromBasicData(5, 'Widget');
      $p2 = Product::fromJson($some_json_string);
      $p3 = Product::fromXml($some_xml_string);
      ```

    - The constructor may be made private or protected to prevent it from being called externally. If so, only a static method will be able to instantiate the class. Because they are in the same class definition they have access to private methods, even if not of the same object instance. The private constructor is optional and may or may not make sense depending on the use case.

    - The three public static methods then demonstrate different ways of instantiating the object.

      - `fromBasicData()` takes the exact parameters that are needed, then creates the object by calling the constructor and returning the result.

      - `fromJson()` accepts a JSON string and does some pre-processing on it itself to convert it into the format desired by the constructor. It then returns the new object.

      - `fromXml()` accepts an XML string, preprocesses it, and then creates a bare object. The constructor is still called, but as all of the parameters are optional the method skips them. It then assigns values to the object properties directly before returning the result.

    - In all three cases, the static keyword is translated into the name of the class the code is in. In this case, Product.

- Destructor

  ```php
  __destruct(): void
  ```

  - PHP possesses a destructor concept similar to that of other object-oriented languages, such as C++. The destructor method will be called as soon as there are no other references to a particular object, or in any order during the shutdown sequence.

  - **Example #6 Destructor Example**

    ```php
    <?php

    class MyDestructableClass
    {
        function __construct() {
            print "In constructor\n";
        }

        function __destruct() {
            print "Destroying " . __CLASS__ . "\n";
        }
    }

    $obj = new MyDestructableClass();

    ```

  - Like constructors, parent destructors will not be called implicitly by the engine. In order to run a parent destructor, one would have to explicitly call `parent::__destruct()` in the destructor body. Also like constructors, a child class may inherit the parent's destructor if it does not implement one itself.

  - The destructor will be called even if script execution is stopped using `exit()`. Calling `exit()` in a destructor will prevent the remaining shutdown routines from executing.

  - Note:

    - Destructors called during the script shutdown have HTTP headers already sent. The working directory in the script shutdown phase can be different with some SAPIs (e.g. Apache).

  - Note:

    - Attempting to throw an exception from a destructor (called in the time of script termination) causes a fatal error.

## 19. Environments and Configuration Flexibility

- About

  We have one glaring issue with our Database class right now. The connection values have been hard-coded. So what happens when we push the project to production, where the host and port are entirely different?

- Things You'll Learn
  - Environments
  - Push Configurable Data Upward

## 20. SQL Injection Vulnerabilities Explained

- About

  In this episode, we'll review some examples of SQL injection and discuss why it's so important that you always assume that, on the web, a person is guilty until proven innocent.

- Things You'll Learn

  - SQL Injection
  - Prepared Statements
  - Parameter Binding

- SQL Injection

  - SQL injection is a technique where an attacker exploits flaws in application code responsible for building dynamic SQL queries. The attacker can gain access to privileged sections of the application, retrieve all information from the database, tamper with existing data, or even execute dangerous system-level commands on the database host. The vulnerability occurs when developers concatenate or interpolate arbitrary input in their SQL statements.

  - **Example #1 Splitting the result set into pages ... and making superusers (PostgreSQL)**

    - In the following example, user input is directly interpolated into the SQL query allowing the attacker to gain a superuser account in the database.

    ```php
    <?php

    $offset = $_GET['offset']; // beware, no input validation!
    $query  = "SELECT id, name FROM products ORDER BY name LIMIT 20 OFFSET $offset;";
    $result = pg_query($conn, $query);

    ?>
    ```

  - Normal users click on the 'next', 'prev' links where the `$offset` is encoded into the URL. The script expects that the incoming `$offset` is a number. However, what if someone tries to break in by appending the following to the URL

  ```sql
  0;
  insert into pg_shadow(usename,usesysid,usesuper,usecatupd,passwd)
      select 'crack', usesysid, 't','t','crack'
      from pg_shadow where usename='postgres';
  --
  ```

  - If it happened, the script would present a superuser access to the attacker. Note that 0; is to supply a valid offset to the original query and to terminate it.

  - Note:

    - It is a common technique to force the SQL parser to ignore the rest of the query written by the developer with -- which is the comment sign in SQL.

  - A feasible way to gain passwords is to circumvent your search result pages. The only thing the attacker needs to do is to see if there are any submitted variables used in SQL statements which are not handled properly. These filters can be set commonly in a preceding form to customize WHERE, ORDER BY, LIMIT and OFFSET clauses in SELECT statements. If your database supports the UNION construct, the attacker may try to append an entire query to the original one to list passwords from an arbitrary table. It is strongly recommended to store only secure hashes of passwords instead of the passwords themselves.

  - **Example #2 Listing out articles ... and some passwords (any database server)**

    ```php
    <?php

    $query  = "SELECT id, name, inserted, size FROM products
              WHERE size = '$size'";
    $result = odbc_exec($conn, $query);

    ?>
    ```

  - The static part of the query can be combined with another SELECT statement which reveals all passwords:

    ```sql
    '
    union select '1', concat(uname||'-'||passwd) as name, '1971-01-01', '0' from usertable;
    --
    ```

  - UPDATE and INSERT statements are also susceptible to such attacks.

  - **Example #3 From resetting a password ... to gaining more privileges (any database server)**

    ```php
    <?php
    $query = "UPDATE usertable SET pwd='$pwd' WHERE uid='$uid';";
    ?>
    ```

  - If a malicious user submits the value ' or uid like'%admin% to $uid to change the admin's password, or simply sets $pwd to hehehe', trusted=100, admin='yes to gain more privileges, then the query will be twisted:

    ```php
    <?php

    // $uid: ' or uid like '%admin%
    $query = "UPDATE usertable SET pwd='...' WHERE uid='' or uid like '%admin%';";

    // $pwd: hehehe', trusted=100, admin='yes
    $query = "UPDATE usertable SET pwd='hehehe', trusted=100, admin='yes' WHERE
    ...;";

    ?>
    ```

  - While it remains obvious that an attacker must possess at least some knowledge of the database architecture to conduct a successful attack, obtaining this information is often very simple. For example, the code may be part of an open-source software and be publicly available. This information may also be divulged by closed-source code - even if it's encoded, obfuscated, or compiled - and even by your own code through the display of error messages. Other methods include the use of typical table and column names. For example, a login form that uses a 'users' table with column names 'id', 'username', and 'password'.

  - **Example #4 Attacking the database host operating system (MSSQL Server)**

    - A frightening example of how operating system-level commands can be accessed on some database hosts.

    ```php
    <?php

    $query  = "SELECT * FROM products WHERE id LIKE '%$prod%'";
    $result = mssql_query($query);

    ?>
    ```

  - If attacker submits the value a%' exec master..xp_cmdshell 'net user test testpass /ADD' -- to $prod, then the $query will be:

    ```php
    <?php

      $query  = "SELECT * FROM products
                WHERE id LIKE '%a%'
                exec master..xp_cmdshell 'net user test testpass /ADD' --%'";
      $result = mssql_query($query);

      ?>
    ```

  - MSSQL Server executes the SQL statements in the batch including a command to add a new user to the local accounts database. If this application were running as sa and the MSSQLSERVER service was running with sufficient privileges, the attacker would now have an account with which to access this machine.

  - Note:

    - Some examples above are tied to a specific database server, but it does not mean that a similar attack is impossible against other products. Your database server may be similarly vulnerable in another manner.

  - Avoidance Techniques

    - The recommended way to avoid SQL injection is by binding all data via prepared statements. Using parameterized queries isn't enough to entirely avoid SQL injection, but it is the easiest and safest way to provide input to SQL statements. All dynamic data literals in WHERE, SET, and VALUES clauses must be replaced with placeholders. The actual data will be bound during the execution and sent separately from the SQL command.

    - Parameter binding can only be used for data. Other dynamic parts of the SQL query must be filtered against a known list of allowed values.

    - **Example #5 Avoiding SQL injection by using PDO prepared statements**

      ```php
      <?php

      // The dynamic SQL part is validated against expected values
      $sortingOrder = $_GET['sortingOrder'] === 'DESC' ? 'DESC' : 'ASC';
      $productId = $_GET['productId'];
      // The SQL is prepared with a placeholder
      $stmt = $pdo->prepare("SELECT * FROM products WHERE id LIKE ? ORDER BY price {$sortingOrder}");
      // The value is provided with LIKE wildcards
      $stmt->execute(["%{$productId}%"]);

      ?>
      ```

    - Prepared statements are provided by PDO, by MySQLi, and by other database libraries.

    - SQL injection attacks are mainly based on exploiting the code not being written with security in mind. Never trust any input, especially from the client side, even though it comes from a select box, a hidden input field, or a cookie. The first example shows that such a simple query can cause disasters.

    - A defense-in-depth strategy involves several good coding practices:

      - Never connect to the database as a superuser or as the database owner. Use always customized users with minimal privileges.

      - Check if the given input has the expected data type. PHP has a wide range of input validating functions, from the simplest ones found in [Variable Functions](https://www.php.net/manual/en/ref.var.php) and in [Character Type Functions](https://www.php.net/manual/en/ref.ctype.php) (e.g. [is_numeric()](https://www.php.net/manual/en/function.is-numeric.php), [ctype_digit()](https://www.php.net/manual/en/function.ctype-digit.php) respectively) and onwards to the [Perl Compatible Regular Expressions](https://www.php.net/manual/en/ref.pcre.php) support.

      - If the application expects numerical input, consider verifying data with [ctype_digit()](https://www.php.net/manual/en/function.ctype-digit.php), silently change its type using [settype()](https://www.php.net/manual/en/function.settype.php), or use its numeric representation by [sprintf()](https://www.php.net/manual/en/function.sprintf.php).
      - If the database layer doesn't support binding variables then quote each non-numeric user-supplied value that is passed to the database with the database-specific string escape function (e.g. [mysql_real_escape_string()](https://www.php.net/manual/en/function.mysql-real-escape-string.php), `sqlite_escape_string()`, etc.). Generic functions like [addslashes()](https://www.php.net/manual/en/function.addslashes.php) are useful only in a very specific environment (e.g. MySQL in a single-byte character set with disabled `NO_BACKSLASH_ESCAPES`), so it is better to avoid them.
      - Do not print out any database-specific information, especially about the schema, by fair means or foul. See also [Error Reporting](https://www.php.net/manual/en/security.errors.php) and [Error Handling and Logging Functions](https://www.php.net/manual/en/ref.errorfunc.php).

- Prepared Statements

  - The MySQL database supports prepared statements. A prepared statement or a parameterized statement is used to execute the same statement repeatedly with high efficiency and protect against SQL injections.

  - _Basic workflow_

    - The prepared statement execution consists of two stages: prepare and execute. At the prepare stage a statement template is sent to the database server. The server performs a syntax check and initializes server internal resources for later use.

    - The MySQL server supports using anonymous, positional placeholder with ?.

    - Prepare is followed by execute. During execute the client binds parameter values and sends them to the server. The server executes the statement with the bound values using the previously created internal resources.

    - **Example #1 Prepared statement**

      ```php
      <?php

      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $mysqli = new mysqli("example.com", "user", "password", "database");

      /* Non-prepared statement */
      $mysqli->query("DROP TABLE IF EXISTS test");
      $mysqli->query("CREATE TABLE test(id INT, label TEXT)");

      /* Prepared statement, stage 1: prepare */
      $stmt = $mysqli->prepare("INSERT INTO test(id, label) VALUES (?, ?)");

      /* Prepared statement, stage 2: bind and execute */
      $id = 1;
      $label = 'PHP';
      $stmt->bind_param("is", $id, $label); // "is" means that $id is bound as an integer and $label as a string

      $stmt->execute();
      ```

  - _Repeated execution_

    - A prepared statement can be executed repeatedly. Upon every execution the current value of the bound variable is evaluated and sent to the server. The statement is not parsed again. The statement template is not transferred to the server again.

    - **Example #2 INSERT prepared once, executed multiple times**

      ```php
      <?php

      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $mysqli = new mysqli("example.com", "user", "password", "database");

      /* Non-prepared statement */
      $mysqli->query("DROP TABLE IF EXISTS test");
      $mysqli->query("CREATE TABLE test(id INT, label TEXT)");

      /* Prepared statement, stage 1: prepare */
      $stmt = $mysqli->prepare("INSERT INTO test(id, label) VALUES (?, ?)");

      /* Prepared statement, stage 2: bind and execute */
      $stmt->bind_param("is", $id, $label); // "is" means that $id is bound as an integer and $label as a string

      $data = [
          1 => 'PHP',
          2 => 'Java',
          3 => 'C++'
      ];
      foreach ($data as $id => $label) {
          $stmt->execute();
      }

      $result = $mysqli->query('SELECT id, label FROM test');
      var_dump($result->fetch_all(MYSQLI_ASSOC));
      ```

      - The above example will output:

        ```bash
        array(3) {
          [0]=>
          array(2) {
            ["id"]=>
            string(1) "1"
            ["label"]=>
            string(3) "PHP"
          }
          [1]=>
          array(2) {
            ["id"]=>
            string(1) "2"
            ["label"]=>
            string(4) "Java"
          }
          [2]=>
          array(2) {
            ["id"]=>
            string(1) "3"
            ["label"]=>
            string(3) "C++"
          }
        }
        ```

    - Every prepared statement occupies server resources. Statements should be closed explicitly immediately after use. If not done explicitly, the statement will be closed when the statement handle is freed by PHP.

    - Using a prepared statement is not always the most efficient way of executing a statement. A prepared statement executed only once causes more client-server round-trips than a non-prepared statement. This is why the SELECT is not run as a prepared statement above.

    - Also, consider the use of the MySQL multi-INSERT SQL syntax for INSERTs. For the example, multi-INSERT requires fewer round-trips between the server and client than the prepared statement shown above.

    - **Example #3 Less round trips using multi-INSERT SQL**

      ```php
      <?php

      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $mysqli = new mysqli("example.com", "user", "password", "database");

      $mysqli->query("DROP TABLE IF EXISTS test");
      $mysqli->query("CREATE TABLE test(id INT)");

      $values = [1, 2, 3, 4];

      $stmt = $mysqli->prepare("INSERT INTO test(id) VALUES (?), (?), (?), (?)");
      $stmt->bind_param('iiii', ...$values);
      $stmt->execute();
      ```

  - _Result set values data types_

    - The MySQL Client Server Protocol defines a different data transfer protocol for prepared statements and non-prepared statements. Prepared statements are using the so called binary protocol. The MySQL server sends result set data "as is" in binary format. Results are not serialized into strings before sending. Client libraries receive binary data and try to convert the values into appropriate PHP data types. For example, results from an SQL INT column will be provided as PHP integer variables.

    - **Example #4 Native datatypes**

      ```php
      <?php

      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $mysqli = new mysqli("example.com", "user", "password", "database");

      /* Non-prepared statement */
      $mysqli->query("DROP TABLE IF EXISTS test");
      $mysqli->query("CREATE TABLE test(id INT, label TEXT)");
      $mysqli->query("INSERT INTO test(id, label) VALUES (1, 'PHP')");

      $stmt = $mysqli->prepare("SELECT id, label FROM test WHERE id = 1");
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();

      printf("id = %s (%s)\n", $row['id'], gettype($row['id']));
      printf("label = %s (%s)\n", $row['label'], gettype($row['label']));
      ```

      - The above example will output:

        ```bash
        id = 1 (integer)
        label = PHP (string)
        ```

    - This behavior differs from non-prepared statements. By default, non-prepared statements return all results as strings. This default can be changed using a connection option. If the connection option is used, there are no differences.

  - _Fetching results using bound variables_

    - Results from prepared statements can either be retrieved by binding output variables, or by requesting a [mysqli_result](https://www.php.net/manual/en/class.mysqli-result.php) object.

    - Output variables must be bound after statement execution. One variable must be bound for every column of the statements result set.

    - **Example #5 Output variable binding**

      ```php
      <?php

      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $mysqli = new mysqli("example.com", "user", "password", "database");

      /* Non-prepared statement */
      $mysqli->query("DROP TABLE IF EXISTS test");
      $mysqli->query("CREATE TABLE test(id INT, label TEXT)");
      $mysqli->query("INSERT INTO test(id, label) VALUES (1, 'PHP')");

      $stmt = $mysqli->prepare("SELECT id, label FROM test WHERE id = 1");
      $stmt->execute();

      $stmt->bind_result($out_id, $out_label);

      while ($stmt->fetch()) {
          printf("id = %s (%s), label = %s (%s)\n", $out_id, gettype($out_id), $out_label, gettype($out_label));
      }
      ```

      - The above example will output:

        ```bash
        id = 1 (integer), label = PHP (string)
        ```

    - Prepared statements return unbuffered result sets by default. The results of the statement are not implicitly fetched and transferred from the server to the client for client-side buffering. The result set takes server resources until all results have been fetched by the client. Thus it is recommended to consume results timely. If a client fails to fetch all results or the client closes the statement before having fetched all data, the data has to be fetched implicitly by mysqli.

    - It is also possible to buffer the results of a prepared statement using [mysqli_stmt::store_result()](https://www.php.net/manual/en/mysqli-stmt.store-result.php).

  - _`Fetching results using mysqli_result interface`_

    - Instead of using bound results, results can also be retrieved through the mysqli_result interface. `mysqli_stmt::get_result()` returns a buffered result set.

    - **Example #6 Using mysqli_result to fetch results**

      ```php
      <?php

      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $mysqli = new mysqli("example.com", "user", "password", "database");

      /* Non-prepared statement */
      $mysqli->query("DROP TABLE IF EXISTS test");
      $mysqli->query("CREATE TABLE test(id INT, label TEXT)");
      $mysqli->query("INSERT INTO test(id, label) VALUES (1, 'PHP')");

      $stmt = $mysqli->prepare("SELECT id, label FROM test WHERE id = 1");
      $stmt->execute();

      $result = $stmt->get_result();

      var_dump($result->fetch_all(MYSQLI_ASSOC));
      ```

      - The above example will output:

        ```bash
        array(1) {
          [0]=>
          array(2) {
            ["id"]=>
            int(1)
            ["label"]=>
            string(3) "PHP"
          }
        }
        ```

    - Using the [mysqli_result](https://www.php.net/manual/en/class.mysqli-result.php) interface offers the additional benefit of flexible client-side result set navigation.

    - **Example #7 Buffered result set for flexible read out**

      ```php
      <?php

      mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
      $mysqli = new mysqli("example.com", "user", "password", "database");

      /* Non-prepared statement */
      $mysqli->query("DROP TABLE IF EXISTS test");
      $mysqli->query("CREATE TABLE test(id INT, label TEXT)");
      $mysqli->query("INSERT INTO test(id, label) VALUES (1, 'PHP'), (2, 'Java'), (3, 'C++')");

      $stmt = $mysqli->prepare("SELECT id, label FROM test");
      $stmt->execute();

      $result = $stmt->get_result();

      for ($row_no = $result->num_rows - 1; $row_no >= 0; $row_no--) {
          $result->data_seek($row_no);
          var_dump($result->fetch_assoc());
      }
      ```

      - The above example will output:

        ```bash
        array(2) {
          ["id"]=>
          int(3)
          ["label"]=>
          string(3) "C++"
        }
        array(2) {
          ["id"]=>
          int(2)
          ["label"]=>
          string(4) "Java"
        }
        array(2) {
          ["id"]=>
          int(1)
          ["label"]=>
          string(3) "PHP"
        }
        ```

  - _Escaping and SQL injection_

    - Bound variables are sent to the server separately from the query and thus cannot interfere with it. The server uses these values directly at the point of execution, after the statement template is parsed. Bound parameters do not need to be escaped as they are never substituted into the query string directly. A hint must be provided to the server for the type of bound variable, to create an appropriate conversion. See the [mysqli_stmt::bind_param()](https://www.php.net/manual/en/mysqli-stmt.bind-param.php) function for more information.

    - Such a separation sometimes considered as the only security feature to prevent SQL injection, but the same degree of security can be achieved with non-prepared statements, if all the values are formatted correctly. It should be noted that correct formatting is not the same as escaping and involves more logic than simple escaping. Thus, prepared statements are simply a more convenient and less error-prone approach to this element of database security.

  - _Client-side prepared statement emulation_

    - The API does not include emulation for client-side prepared statement emulation.

# 3. Notes Mini-Project

## 21. Database Tables and Indexes

- About

  - You've learned enough of the fundamentals at this point to begin working on your first mini-project. Let's make a notes app! We'll begin with the initial database structure, which will give us the opportunity to review MySQL indexes.

- Things You'll Learn
  - Table Relationships
  - Indexes

## 22. Render the Notes and Note Page

- About

  Now that we have the initial database structure in place, let's create one page to display all of John Doe's notes, and then another page for each individual note.

- Things You'll Learn

  - Fetch Notes By User

## 23. Introduction to Authorization

- About

  In the previous episode, we added support for reading all notes that were created by a particular user. But, in doing so, we unwittingly introduced a major security concern. In this lesson, we'll discuss authorization, status codes, and magic numbers.

- Things You'll Learn

  - Authorization

  - Magic Numbers

  - Status Codes

## 24. Programming is Rewriting

- About

  Before we move on to building a form to persist new notes to the database, let's take ten minutes to refactor our current code and discuss wrapping up APIs you don't own.

- Things You'll Learn
  - Refactoring
  - API Ownership

## 25. Intro to Forms and Request Methods

- About

  We're overdue, but it's finally time to dig into forms. In this lesson, we'll learn how to submit a form using two different request methods. Next, we'll discuss how our controller might detect whether a POST submission has occurred.

- Things You'll Learn
  - Forms
  - GET Requests
  - POST Requests

## 26. Always Escape Untrusted Input

- About

  In this lesson, we'll finally persist a new note to the database. But, in doing so, you'll be introduced to a new security concern that requires us to always escape user-provided input.

- Things You'll Learn

  - Insert Queries
  - htmlspecialchars()

- htmlspecialchars

  - (PHP 4, PHP 5, PHP 7, PHP 8)

  - htmlspecialchars — Convert special characters to HTML entities

  - Description

    ```php
    htmlspecialchars(
        string $string,
        int $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401,
        ?string $encoding = null,
        bool $double_encode = true
    ): string
    ```

    - Certain characters have special significance in HTML, and should be represented by HTML entities if they are to preserve their meanings. This function returns a string with these conversions made. If you require all input substrings that have associated named entities to be translated, use [htmlentities()](https://www.php.net/manual/en/function.htmlentities.php) instead.

    - If the input string passed to this function and the final document share the same character set, this function is sufficient to prepare input for inclusion in most contexts of an HTML document. If, however, the input can represent characters that are not coded in the final document character set and you wish to retain those characters (as numeric or named entities), both this function and [htmlentities()](https://www.php.net/manual/en/function.htmlentities.php) (which only encodes substrings that have named entity equivalents) may be insufficient. You may have to use [mb_encode_numericentity()](https://www.php.net/manual/en/function.mb-encode-numericentity.php) instead.

    - **Performed translations**

    | Character        | Replacement                                                                                                |
    | ---------------- | ---------------------------------------------------------------------------------------------------------- |
    | & (ampersand)    | &amp;                                                                                                      |
    | " (double quote) | &quot;, unless ENT_NOQUOTES is set                                                                         |
    | ' (single quote) | &#039; (for ENT_HTML401) or &apos; (for ENT_XML1, ENT_XHTML or ENT_HTML5), but only when ENT_QUOTES is set |
    | < (less than)    | &lt;                                                                                                       |
    | > (greater than) | &gt;                                                                                                       |

  - Parameters

    - string

      - The string being converted.

    - flags

      - A bitmask of one or more of the following flags, which specify how to handle quotes, invalid code unit sequences and the used document type. The default is ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401.

    - encoding

      - An optional argument defining the encoding used when converting characters.
      - If omitted, encoding defaults to the value of the default_charset configuration option.

    - double_encode
      - When double_encode is turned off PHP will not encode existing html entities, the default is to convert everything.

  - Return Values

    - The converted string.
    - If the input `string` contains an invalid code unit sequence within the given `encoding` an empty string will be returned, unless either the `ENT_IGNORE` or `ENT_SUBSTITUTE` flags are set.

  - Examples

    - **Example #1 htmlspecialchars() example**

      ```php
      <?php
      $new = htmlspecialchars("<a href='test'>Test</a>", ENT_QUOTES);
      echo $new; // &lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;
      ?>
      ```

  - Notes ¶

    - Note:

      - Note that this function does not translate anything beyond what is listed above. For full entity translation, see `htmlentities()`.

    - Note:

      - In case of an ambiguous `flags` value, the following rules apply:

        - When neither of `ENT_COMPAT`, `ENT_QUOTES`, `ENT_NOQUOTES` is present, the default is `ENT_NOQUOTES`.

        - When more than one of `ENT_COMPAT`, `ENT_QUOTES`, `ENT_NOQUOTES` is present, `ENT_QUOTES` takes the highest precedence, followed by `ENT_COMPAT`.

        - When neither of `ENT_HTML401`, `ENT_HTML5`, `ENT_XHTML`, `ENT_XML1` is present, the default is `ENT_HTML401`.

        - When more than one of `ENT_HTML401`, `ENT_HTML5`, `ENT_XHTML`, `ENT_XML1` is present, `ENT_HTML5` takes the highest precedence, followed by `ENT_XHTML`, `ENT_XML1` and `ENT_HTML401`.

        - When more than one of `ENT_DISALLOWED`, `ENT_IGNORE`, `ENT_SUBSTITUTE` are present, `ENT_IGNORE` takes the highest precedence, followed by `ENT_SUBSTITUTE`.

## 27. Intro to Form Validation

- About

  In this lesson, we'll review two layers of form validation: browser and server-side. We can use validation to ensure and confirm that the user submits their data in the exact format that we require.

- Things You'll Learn

  - Browser Validation
  - Server-side Validation
  - strlen()

- Browser validation is useful because it provides us instant feedback

  - For example, you can add `required` attribute to the form field.
  - But browser validation is not sufficient

    - User can bypass the validation, for example:

      ```bash
      curl -X POST http://localhost:8888/notes/create -d 'body='
      ```

- strlen

  - (PHP 4, PHP 5, PHP 7, PHP 8)

  - strlen — Get string length

  - Description ¶

    ```php
    strlen(string $string): int
    ```

    - Returns the length of the given string.

  - Parameters ¶

    - string
      - The string being measured for length.

  - Return Values ¶

    - The length of the string in bytes.

  - Examples ¶

    - **Example #1 A strlen() example**

      ```php
      <?php
      $str = 'abcdef';
      echo strlen($str); // 6

      $str = ' ab cd ';
      echo strlen($str); // 7
      ?>
      ```

  - Notes ¶
    - Note:
      - strlen() returns the number of bytes rather than the number of characters in a string.

## 28. Extract a Simple Validator Class

- About

  To make for a more flexible and readable experience, let's extract the basic validation rules we wrote in the previous episode into a dedicated Validator class.

- Things You'll Learn
  - Validation
  - Pure Functions
  - Static Methods

# 4. Project Organization

## 29. Resourceful Naming Conventions

- About

  Let's take a short pause on the notes exercise, and instead switch our attention to general code organization. We'll start by switching to a common naming convention for resources.

- Things You'll Learn
  - Resources
  - Common Action Names

## 30. PHP Autoloading and Extraction

- About

  Okay, buckle up. This will be the most dense episode yet, as we discuss a variety of topics related to project organization. We'll touch on document roots, helper functions, constants, PHP autoloading, and more.

- Things You'll Learn

  - Autoloading Classes
  - Document Root
  - extract()

- Autoloading Classes

  - Many developers writing object-oriented applications create one PHP source file per class definition. One of the biggest annoyances is having to write a long list of needed includes at the beginning of each script (one for each class).

  - The [spl_autoload_register()](https://www.php.net/manual/en/function.spl-autoload-register.php) function registers any number of autoloaders, enabling for classes and interfaces to be automatically loaded if they are currently not defined. By registering autoloaders, PHP is given a last chance to load the class or interface before it fails with an error.

  - Any class-like construct may be autoloaded the same way. That includes classes, interfaces, traits, and enumerations.

  - Caution

    - Prior to PHP 8.0.0, it was possible to use `__autoload()` to autoload classes and interfaces. However, it is a less flexible alternative to `spl_autoload_register()` and `__autoload()` is deprecated as of PHP 7.2.0, and removed as of PHP 8.0.0.

  - Note:

    - `spl_autoload_register()` may be called multiple times in order to register multiple autoloaders. Throwing an exception from an autoload function, however, will interrupt that process and not allow further autoload functions to run. For that reason, throwing exceptions from an autoload function is strongly discouraged.

  - **Example #1 Autoload example**

    - This example attempts to load the classes `MyClass1` and `MyClass2` from the files `MyClass1.php` and `MyClass2.php` respectively.

    ```php
    <?php
    spl_autoload_register(function ($class_name) {
        include $class_name . '.php';
    });

    $obj  = new MyClass1();
    $obj2 = new MyClass2();
    ?>
    ```

  - **Example #2 Autoload other example**

    - This example attempts to load the interface ITest.

    ```php
    <?php

    spl_autoload_register(function ($name) {
        var_dump($name);
    });

    class Foo implements ITest {
    }

    /*
    string(5) "ITest"

    Fatal error: Interface 'ITest' not found in ...
    */
    ?>
    ```

- SPL

  - The Standard PHP Library (SPL) is a collection of interfaces and classes that are meant to solve common problems.

  - SPL provides a set of standard datastructure, a set of iterators to traverse over objects, a set of interfaces, a set of standard Exceptions, a number of classes to work with files and it provides a set of functions like `spl_autoload_register()`

- Document Root

  - By default, we can access all the php files inside the document root, for example, localhost:8888/router.php, localhost:8888/config.php.

    - These are all security issues.

  - So we are fixing this issue by setting the specific folder(for example, /public) as document root.

  ```bash
  php -S localhost:8888 -t public
  ```

- extract

  - (PHP 4, PHP 5, PHP 7, PHP 8)

  - extract — Import variables into the current symbol table from an array

  - Description ¶

    ```php
    extract(array &$array, int $flags = EXTR_OVERWRITE, string $prefix = ""): int
    ```

    - Import variables from an array into the current symbol table.

    - Checks each key to see whether it has a valid variable name. It also checks for collisions with existing variables in the symbol table.

    - **Warning**
      - Do not use `extract()` on untrusted data, like user input (e.g. `$_GET`, `$_FILES`).

  - Parameters ¶

    - array

      - An associative array. This function treats keys as variable names and values as variable values. For each key/value pair it will create a variable in the current symbol table, subject to `flags` and `prefix` parameters.

      - You must use an associative array; a numerically indexed array will not produce results unless you use `EXTR_PREFIX_ALL` or `EXTR_PREFIX_INVALID`.

    - flags

      - The way invalid/numeric keys and collisions are treated is determined by the extraction flags. It can be one of the following values:

      - EXTR_OVERWRITE
        - If there is a collision, overwrite the existing variable.
      - EXTR_SKIP
        - If there is a collision, don't overwrite the existing variable.
      - EXTR_PREFIX_SAME
        - If there is a collision, prefix the variable name with prefix.
      - EXTR_PREFIX_ALL
        - Prefix all variable names with prefix.
      - EXTR_PREFIX_INVALID
        - Only prefix invalid/numeric variable names with prefix.
      - EXTR_IF_EXISTS
        - Only overwrite the variable if it already exists in the current symbol table, otherwise do nothing. This is useful for defining a list of valid variables and then extracting only those variables you have defined out of $\_REQUEST, for example.
      - EXTR_PREFIX_IF_EXISTS
        - Only create prefixed variable names if the non-prefixed version of the same variable exists in the current symbol table.
      - EXTR_REFS
        - Extracts variables as references. This effectively means that the values of the imported variables are still referencing the values of the array parameter. You can use this flag on its own or combine it with any other flag by OR'ing the flags.
          If flags is not specified, it is assumed to be EXTR_OVERWRITE.

    - prefix
      - Note that `prefix` is only required if flags is `EXTR_PREFIX_SAME`, `EXTR_PREFIX_ALL`, `EXTR_PREFIX_INVALID` or `EXTR_PREFIX_IF_EXISTS`. If the prefixed result is not a valid variable name, it is not imported into the symbol table. Prefixes are automatically separated from the array key by an underscore character.

  - Return Values ¶

    - Returns the number of variables successfully imported into the symbol table.

  - Examples ¶

    - **Example #1 extract() example**

      - A possible use for `extract()` is to import into the symbol table variables contained in an associative array returned by [wddx_deserialize()](https://www.php.net/manual/en/function.wddx-deserialize.php).

      ```php
      <?php

      /* Suppose that $var_array is an array returned from
        wddx_deserialize */

      $size = "large";
      $var_array = array("color" => "blue",
                        "size"  => "medium",
                        "shape" => "sphere");
      extract($var_array, EXTR_PREFIX_SAME, "wddx");

      echo "$color, $size, $shape, $wddx_size\n";

      ?>
      ```

      - The above example will output:

        ```bash
        blue, large, sphere, medium
        ```

      - The `$size` wasn't overwritten because we specified `EXTR_PREFIX_SAME`, which resulted in `$wddx_size` being created. If `EXTR_SKIP` was specified, then `$wddx_size` wouldn't even have been created. `EXTR_OVERWRITE` would have caused `$size` to have value "medium", and `EXTR_PREFIX_ALL` would result in new variables being named `$wddx_color`, `$wddx_size`, and `$wddx_shape`.

## 31. Namespacing: What, Why, How?

- About

  It's time to discuss PHP namespacing, but don't worry: I'm going to make this incredibly easy to understand. If you can remember the days of storing your entire music collection locally, you'll grasp namespacing in seconds.

- Things You'll Learn

  - PHP Namespaces
  - The `use` Keyword

- Namespaces

  - Namespaces overview

    - (PHP 5 >= 5.3.0, PHP 7, PHP 8)

    - What are namespaces? In the broadest definition namespaces are a way of encapsulating items. This can be seen as an abstract concept in many places. For example, in any operating system directories serve to group related files, and act as a namespace for the files within them. As a concrete example, the file foo.txt can exist in both directory /home/greg and in /home/other, but two copies of foo.txt cannot co-exist in the same directory. In addition, to access the foo.txt file outside of the /home/greg directory, we must prepend the directory name to the file name using the directory separator to get /home/greg/foo.txt. This same principle extends to namespaces in the programming world.

    - In the PHP world, namespaces are designed to solve two problems that authors of libraries and applications encounter when creating re-usable code elements such as classes or functions:

      1. Name collisions between code you create, and internal PHP classes/functions/constants or third-party classes/functions/constants.
      2. Ability to alias (or shorten) Extra_Long_Names designed to alleviate the first problem, improving readability of source code.

    - PHP Namespaces provide a way in which to group related classes, interfaces, functions and constants. Here is an example of namespace syntax in PHP:

      - **Example #1 Namespace syntax example**

        ```php
        <?php
        namespace my\name; // see "Defining Namespaces" section

        class MyClass {}
        function myfunction() {}
        const MYCONST = 1;

        $a = new MyClass;
        $c = new \my\name\MyClass; // see "Global Space" section

        $a = strlen('hi'); // see "Using namespaces: fallback to global
                          // function/constant" section

        $d = namespace\MYCONST; // see "namespace operator and __NAMESPACE__
                                // constant" section
        $d = __NAMESPACE__ . '\MYCONST';
        echo constant($d); // see "Namespaces and dynamic language features" section
        ?>
        ```

    - **Note**: Namespace names are case-insensitive.

    - **Note:**

      - The Namespace name PHP, and compound names starting with this name (like PHP\Classes) are reserved for internal language use and should not be used in the userspace code.

  - Defining namespaces

    (PHP 5 >= 5.3.0, PHP 7, PHP 8)

    - Although any valid PHP code can be contained within a namespace, only the following types of code are affected by namespaces: classes (including abstracts and traits), interfaces, functions and constants.

    - Namespaces are declared using the `namespace` keyword. A file containing a namespace must declare the namespace at the top of the file before any other code - with one exception: the [declare](https://www.php.net/manual/en/control-structures.declare.php) keyword.

    - **Example #1 Declaring a single namespace**

      ```php
      <?php
      namespace MyProject;

      const CONNECT_OK = 1;
      class Connection { /* ... */ }
      function connect() { /* ... */ }

      ?>
      ```

    - Note: Fully qualified names (i.e. names starting with a backslash) are not allowed in namespace declarations, because such constructs are interpreted as relative namespace expressions.

    - The only code construct allowed before a namespace declaration is the declare statement, for defining encoding of a source file. In addition, no non-PHP code may precede a namespace declaration, including extra whitespace:

      - **Example #2 Declaring a single namespace**

        ```php
        <html>
        <?php
        namespace MyProject; // fatal error - namespace must be the first statement in the script
        ?>
        ```

    - In addition, unlike any other PHP construct, the same namespace may be defined in multiple files, allowing splitting up of a namespace's contents across the filesystem.

  - Declaring sub-namespaces ¶

    - (PHP 5 >= 5.3.0, PHP 7, PHP 8)

    - Much like directories and files, PHP namespaces also contain the ability to specify a hierarchy of namespace names. Thus, a namespace name can be defined with sub-levels:

    - **Example #1 Declaring a single namespace with hierarchy**

      ```php
      <?php
      namespace MyProject\Sub\Level;

      const CONNECT_OK = 1;
      class Connection { /* ... */ }
      function connect() { /* ... */  }

      ?>
      ```

      - The above example creates constant `MyProject\Sub\Level\CONNECT_OK`, class `MyProject\Sub\Level\Connection` and function `MyProject\Sub\Level\connect`.

  - Defining multiple namespaces in the same file ¶

    - (PHP 5 >= 5.3.0, PHP 7, PHP 8)

    - Multiple namespaces may also be declared in the same file. There are two allowed syntaxes.

    - **Example #1 Declaring multiple namespaces, simple combination syntax**

      ```php
      <?php
      namespace MyProject;

      const CONNECT_OK = 1;
      class Connection { /* ... */ }
      function connect() { /* ... */  }

      namespace AnotherProject;

      const CONNECT_OK = 1;
      class Connection { /* ... */ }
      function connect() { /* ... */  }
      ?>
      ```

      - This syntax is not recommended for combining namespaces into a single file. Instead it is recommended to use the alternate bracketed syntax.

    - **Example #2 Declaring multiple namespaces, bracketed syntax**

      ```php
      <?php
      namespace MyProject {

      const CONNECT_OK = 1;
      class Connection { /* ... */ }
      function connect() { /* ... */  }
      }

      namespace AnotherProject {

      const CONNECT_OK = 1;
      class Connection { /* ... */ }
      function connect() { /* ... */  }
      }
      ?>
      ```

      - It is strongly discouraged as a coding practice to combine multiple namespaces into the same file. The primary use case is to combine multiple PHP scripts into the same file.

      - To combine global non-namespaced code with namespaced code, only bracketed syntax is supported. Global code should be encased in a namespace statement with no namespace name as in:

    - **Example #3 Declaring multiple namespaces and unnamespaced code**

      ```php
      <?php
      namespace MyProject {

      const CONNECT_OK = 1;
      class Connection { /* ... */ }
      function connect() { /* ... */  }
      }

      namespace { // global code
      session_start();
      $a = MyProject\connect();
      echo MyProject\Connection::start();
      }
      ?>
      ```

    - No PHP code may exist outside of the namespace brackets except for an opening declare statement.

      - **Example #4 Declaring multiple namespaces and unnamespaced code**

        ```php
        <?php
        declare(encoding='UTF-8');
        namespace MyProject {

        const CONNECT_OK = 1;
        class Connection { /* ... */ }
        function connect() { /* ... */  }
        }

        namespace { // global code
        session_start();
        $a = MyProject\connect();
        echo MyProject\Connection::start();
        }
        ?>
        ```

  - Using namespaces: Basics

    - file1.php

      ```php
      <?php
      namespace Foo\Bar\subnamespace;

      const FOO = 1;
      function foo() {}
      class foo
      {
          static function staticmethod() {}
      }
      ?>
      ```

    - file2.php

      ```php
      <?php
      namespace Foo\Bar;
      include 'file1.php';

      const FOO = 2;
      function foo() {}
      class foo
      {
          static function staticmethod() {}
      }

      /* Unqualified name */
      foo(); // resolves to function Foo\Bar\foo
      foo::staticmethod(); // resolves to class Foo\Bar\foo, method staticmethod
      echo FOO; // resolves to constant Foo\Bar\FOO

      /* Qualified name */
      subnamespace\foo(); // resolves to function Foo\Bar\subnamespace\foo
      subnamespace\foo::staticmethod(); // resolves to class Foo\Bar\subnamespace\foo,
                                        // method staticmethod
      echo subnamespace\FOO; // resolves to constant Foo\Bar\subnamespace\FOO

      /* Fully qualified name */
      \Foo\Bar\foo(); // resolves to function Foo\Bar\foo
      \Foo\Bar\foo::staticmethod(); // resolves to class Foo\Bar\foo, method staticmethod
      echo \Foo\Bar\FOO; // resolves to constant Foo\Bar\FOO
      ?>
      ```

    - Note that to access any global class, function or constant, a fully qualified name can be used, such as `\strlen()` or `\Exception` or `\INI_ALL`.

      - **Example #1 Accessing global classes, functions and constants from within a namespace**

        ```php
        <?php
        namespace Foo;

        function strlen() {}
        const INI_ALL = 3;
        class Exception {}

        $a = \strlen('hi'); // calls global function strlen
        $b = \INI_ALL; // accesses global constant INI_ALL
        $c = new \Exception('error'); // instantiates global class Exception
        ?>
        ```

  - Namespaces and dynamic language features ¶

    - (PHP 5 >= 5.3.0, PHP 7, PHP 8)

    - PHP's implementation of namespaces is influenced by its dynamic nature as a programming language. Thus, to convert code like the following example into namespaced code:

    - **Example #1 Dynamically accessing elements**

      - example1.php:

      ```php
      <?php
      class classname
      {
          function __construct()
          {
              echo __METHOD__,"\n";
          }
      }
      function funcname()
      {
          echo __FUNCTION__,"\n";
      }
      const constname = "global";

      $a = 'classname';
      $obj = new $a; // prints classname::__construct
      $b = 'funcname';
      $b(); // prints funcname
      echo constant('constname'), "\n"; // prints global
      ?>
      ```

    - One must use the fully qualified name (class name with namespace prefix). Note that because there is no difference between a qualified and a fully qualified Name inside a dynamic class name, function name, or constant name, the leading backslash is not necessary.
    - **Example #2 Dynamically accessing namespaced elements**

      ```php
      <?php
      namespace namespacename;
      class classname
      {
          function __construct()
          {
              echo __METHOD__,"\n";
          }
      }
      function funcname()
      {
          echo __FUNCTION__,"\n";
      }
      const constname = "namespaced";

      /* note that if using double quotes, "\\namespacename\\classname" must be used */
      $a = '\namespacename\classname';
      $obj = new $a; // prints namespacename\classname::__construct
      $a = 'namespacename\classname';
      $obj = new $a; // also prints namespacename\classname::__construct
      $b = 'namespacename\funcname';
      $b(); // prints namespacename\funcname
      $b = '\namespacename\funcname';
      $b(); // also prints namespacename\funcname
      echo constant('\namespacename\constname'), "\n"; // prints namespaced
      echo constant('namespacename\constname'), "\n"; // also prints namespaced
      ?>
      ```

    - Be sure to read the note about escaping namespace names in strings.

      - Dynamic namespace names (quoted identifiers) should escape backslash ¶

        - It is very important to realize that because the backslash is used as an escape character within strings, it should always be doubled when used inside a string. Otherwise there is a risk of unintended consequences:

        - **Example #9 Dangers of using namespaced names inside a double-quoted string**

          ```php
          <?php
          $a = "dangerous\name"; // \n is a newline inside double quoted strings!
          $obj = new $a;

          $a = 'not\at\all\dangerous'; // no problems here.
          $obj = new $a;
          ?>
          ```

        - Inside a single-quoted string, the backslash escape sequence is much safer to use, but it is still recommended practice to escape backslashes in all strings as a best practice.

  - namespace keyword and `__NAMESPACE__` constant ¶

    - (PHP 5 >= 5.3.0, PHP 7, PHP 8)

    - PHP supports two ways of abstractly accessing elements within the current namespace, the `__NAMESPACE__` magic constant, and the `namespace` keyword.

    - The value of `__NAMESPACE__` is a string that contains the current namespace name. In global, un-namespaced code, it contains an empty string.

      - **Example #1 `__NAMESPACE__` example, namespaced code**

        ```php
        <?php
        namespace MyProject;

        echo '"', __NAMESPACE__, '"'; // outputs "MyProject"
        ?>
        ```

      - **Example #2 `__NAMESPACE__` example, global code**

        ```php
        <?php

        echo '"', __NAMESPACE__, '"'; // outputs ""
        ?>
        ```

    - The `__NAMESPACE__` constant is useful for dynamically constructing names, for instance:

      - **Example #3 using `__NAMESPACE__` for dynamic name construction**

        ```php
        <?php
        namespace MyProject;

        function get($classname)
        {
            $a = __NAMESPACE__ . '\\' . $classname;
            return new $a;
        }
        ?>
        ```

    - The namespace keyword can be used to explicitly request an element from the current namespace or a sub-namespace. It is the namespace equivalent of the `self` operator for classes.

      - **Example #4 the namespace operator, inside a namespace**

        ```php
        <?php
        namespace MyProject;

        use blah\blah as mine; // see "Using namespaces: Aliasing/Importing"

        blah\mine(); // calls function MyProject\blah\mine()
        namespace\blah\mine(); // calls function MyProject\blah\mine()

        namespace\func(); // calls function MyProject\func()
        namespace\sub\func(); // calls function MyProject\sub\func()
        namespace\cname::method(); // calls static method "method" of class MyProject\cname
        $a = new namespace\sub\cname(); // instantiates object of class MyProject\sub\cname
        $b = namespace\CONSTANT; // assigns value of constant MyProject\CONSTANT to $b
        ?>
        ```

      - **Example #5 the namespace operator, in global code**

        ```php
        <?php

        namespace\func(); // calls function func()
        namespace\sub\func(); // calls function sub\func()
        namespace\cname::method(); // calls static method "method" of class cname
        $a = new namespace\sub\cname(); // instantiates object of class sub\cname
        $b = namespace\CONSTANT; // assigns value of constant CONSTANT to $b
        ?>
        ```

  - Using namespaces: Aliasing/Importing ¶

    - (PHP 5 >= 5.3.0, PHP 7, PHP 8)

    - The ability to refer to an external fully qualified name with an alias, or importing, is an important feature of namespaces. This is similar to the ability of unix-based filesystems to create symbolic links to a file or to a directory.

    - PHP can alias(/import) constants, functions, classes, interfaces, traits, enums and namespaces.

    - Aliasing is accomplished with the `use` operator. Here is an example showing all 5 kinds of importing:

      - **Example #1 importing/aliasing with the use operator**

        ```php
        <?php
        namespace foo;
        use My\Full\Classname as Another;

        // this is the same as use My\Full\NSname as NSname
        use My\Full\NSname;

        // importing a global class
        use ArrayObject;

        // importing a function
        use function My\Full\functionName;

        // aliasing a function
        use function My\Full\functionName as func;

        // importing a constant
        use const My\Full\CONSTANT;

        $obj = new namespace\Another; // instantiates object of class foo\Another
        $obj = new Another; // instantiates object of class My\Full\Classname
        NSname\subns\func(); // calls function My\Full\NSname\subns\func
        $a = new ArrayObject(array(1)); // instantiates object of class ArrayObject
        // without the "use ArrayObject" we would instantiate an object of class foo\ArrayObject
        func(); // calls function My\Full\functionName
        echo CONSTANT; // echoes the value of My\Full\CONSTANT
        ?>
        ```

    - Note that for namespaced names (fully qualified namespace names containing namespace separator, such as Foo\Bar as opposed to global names that do not, such as FooBar), the leading backslash is unnecessary and not recommended, as import names must be fully qualified, and are not processed relative to the current namespace.
    - PHP additionally supports a convenience shortcut to place multiple use statements on the same line

      - **Example #2 importing/aliasing with the use operator, multiple use statements combined**

        ```php
        <?php
        use My\Full\Classname as Another, My\Full\NSname;

        $obj = new Another; // instantiates object of class My\Full\Classname
        NSname\subns\func(); // calls function My\Full\NSname\subns\func
        ?>
        ```

    - Importing is performed at compile-time, and so does not affect dynamic class, function or constant names.

      - **Example #3 Importing and dynamic names**

        ```php
        <?php
        use My\Full\Classname as Another, My\Full\NSname;

        $obj = new Another; // instantiates object of class My\Full\Classname
        $a = 'Another';
        $obj = new $a;      // instantiates object of class Another
        ?>
        ```

    - In addition, importing only affects unqualified and qualified names. Fully qualified names are absolute, and unaffected by imports.

      - **Example #4 Importing and fully qualified names**

        ```php
        <?php
        use My\Full\Classname as Another, My\Full\NSname;

        $obj = new Another; // instantiates object of class My\Full\Classname
        $obj = new \Another; // instantiates object of class Another
        $obj = new Another\thing; // instantiates object of class My\Full\Classname\thing
        $obj = new \Another\thing; // instantiates object of class Another\thing
        ?>
        ```

  - Scoping rules for importing ¶

    - The `use` keyword must be declared in the outermost scope of a file (the global scope) or inside namespace declarations. This is because the importing is done at compile time and not runtime, so it cannot be block scoped. The following example will show an illegal use of the `use` keyword:

      - **Example #5 Illegal importing rule**

        ```php
        <?php
        namespace Languages;

        function toGreenlandic()
        {
            use Languages\Danish;

            // ...
        }
        ?>

        ```

      - Note:

        - Importing rules are per file basis, meaning included files will NOT inherit the parent file's importing rules.

  - Group use declarations ¶

    - Classes, functions and constants being imported from the same namespace can be grouped together in a single use statement.

      ```php
      <?php

      use some\namespace\ClassA;
      use some\namespace\ClassB;
      use some\namespace\ClassC as C;

      use function some\namespace\fn_a;
      use function some\namespace\fn_b;
      use function some\namespace\fn_c;

      use const some\namespace\ConstA;
      use const some\namespace\ConstB;
      use const some\namespace\ConstC;

      // is equivalent to the following groupped use declaration
      use some\namespace\{ClassA, ClassB, ClassC as C};
      use function some\namespace\{fn_a, fn_b, fn_c};
      use const some\namespace\{ConstA, ConstB, ConstC};
      ```

  - Global space ¶

    - PHP 5 >= 5.3.0, PHP 7, PHP 8)

    - Without any namespace definition, all class and function definitions are placed into the global space - as it was in PHP before namespaces were supported. Prefixing a name with \ will specify that the name is required from the global space even in the context of the namespace.

      - **Example #1 Using global space specification**

        ```php
        <?php
        namespace A\B\C;

        /* This function is A\B\C\fopen */
        function fopen() {
            /* ... */
            $f = \fopen(...); // call global fopen
            return $f;
        }
        ?>
        ```

  - Using namespaces: fallback to global function/constant ¶

    - (PHP 5 >= 5.3.0, PHP 7, PHP 8)

    - Inside a namespace, when PHP encounters an unqualified Name in a class name, function or constant context, it resolves these with different priorities. Class names always resolve to the current namespace name. Thus to access internal or non-namespaced user classes, one must refer to them with their fully qualified Name as in:

      - **Example #1 Accessing global classes inside a namespace**

        ```php
        <?php
        namespace A\B\C;
        class Exception extends \Exception {}

        $a = new Exception('hi'); // $a is an object of class A\B\C\Exception
        $b = new \Exception('hi'); // $b is an object of class Exception

        $c = new ArrayObject; // fatal error, class A\B\C\ArrayObject not found
        ?>
        ```

    - For functions and constants, PHP will fall back to global functions or constants if a namespaced function or constant does not exist.

      - **Example #2 global functions/constants fallback inside a namespace**

        ```php
        <?php
        namespace A\B\C;

        const E_ERROR = 45;
        function strlen($str)
        {
            return \strlen($str) - 1;
        }

        echo E_ERROR, "\n"; // prints "45"
        echo INI_ALL, "\n"; // prints "7" - falls back to global INI_ALL

        echo strlen('hi'), "\n"; // prints "1"
        if (is_array('hi')) { // prints "is not array"
            echo "is array\n";
        } else {
            echo "is not array\n";
        }
        ?>
        ```

  - Name resolution rules ¶

    - (PHP 5 >= 5.3.0, PHP 7, PHP 8)

    - For the purposes of these resolution rules, here are some important definitions:

      - **Namespace name definitions**

        - Unqualified name

          - This is an identifier without a namespace separator, such as Foo

        - Qualified name

          - This is an identifier with a namespace separator, such as Foo\Bar

        - Fully qualified name
          This is an identifier with a namespace separator that begins with a namespace separator, such as \Foo\Bar. The namespace \Foo is also a fully qualified name.

        - Relative name
          - This is an identifier starting with `namespace`, such as `namespace\Foo\Bar`.

    - Names are resolved following these resolution rules:

      1. Fully qualified names always resolve to the name without leading namespace separator. For instance \A\B resolves to A\B.

      2. Relative names always resolve to the name with `namespace` replaced by the current namespace. If the name occurs in the global namespace, the `namespace\` prefix is stripped. For example `namespace\A` inside namespace `X\Y` resolves to `X\Y\A`. The same name inside the global namespace resolves to `A`.
      3. For qualified names the first segment of the name is translated according to the current class/namespace import table. For example, if the namespace `A\B\C` is imported as `C`, the name `C\D\E` is translated to `A\B\C\D\E`.

      4. For qualified names, if no import rule applies, the current namespace is prepended to the name. For example, the name `C\D\E` inside namespace `A\B`, resolves to `A\B\C\D\E`.

      5. For unqualified names, the name is translated according to the current import table for the respective symbol type. This means that class-like names are translated according to the class/namespace import table, function names according to the function import table and constants according to the constant import table. For example, after `use A\B\C;` a usage such as `new C()` resolves to the name `A\B\C()`. Similarly, after `use function A\B\fn;` a usage such as `fn()` resolves to the name `A\B\fn`.
      6. For unqualified names, if no import rule applies and the name refers to a class-like symbol, the current namespace is prepended. For example `new C()` inside namespace `A\B` resolves to name `A\B\C`.
      7. For unqualified names, if no import rule applies and the name refers to a function or constant and the code is outside the global namespace, the name is resolved at runtime. Assuming the code is in namespace `A\B`, here is how a call to function `foo()` is resolved:

      - 1. It looks for a function from the current namespace: `A\B\foo()`.
      - 2. It tries to find and call the global function `foo()`.

    - **Example #1 Name resolutions illustrated**

      ```php
      <?php
      namespace A;
      use B\D, C\E as F;

      // function calls

      foo();      // first tries to call "foo" defined in namespace "A"
                  // then calls global function "foo"

      \foo();     // calls function "foo" defined in global scope

      my\foo();   // calls function "foo" defined in namespace "A\my"

      F();        // first tries to call "F" defined in namespace "A"
                  // then calls global function "F"

      // class references

      new B();    // creates object of class "B" defined in namespace "A"
                  // if not found, it tries to autoload class "A\B"

      new D();    // using import rules, creates object of class "D" defined in namespace "B"
                  // if not found, it tries to autoload class "B\D"

      new F();    // using import rules, creates object of class "E" defined in namespace "C"
                  // if not found, it tries to autoload class "C\E"

      new \B();   // creates object of class "B" defined in global scope
                  // if not found, it tries to autoload class "B"

      new \D();   // creates object of class "D" defined in global scope
                  // if not found, it tries to autoload class "D"

      new \F();   // creates object of class "F" defined in global scope
                  // if not found, it tries to autoload class "F"

      // static methods/namespace functions from another namespace

      B\foo();    // calls function "foo" from namespace "A\B"

      B::foo();   // calls method "foo" of class "B" defined in namespace "A"
                  // if class "A\B" not found, it tries to autoload class "A\B"

      D::foo();   // using import rules, calls method "foo" of class "D" defined in namespace "B"
                  // if class "B\D" not found, it tries to autoload class "B\D"

      \B\foo();   // calls function "foo" from namespace "B"

      \B::foo();  // calls method "foo" of class "B" from global scope
                  // if class "B" not found, it tries to autoload class "B"

      // static methods/namespace functions of current namespace

      A\B::foo();   // calls method "foo" of class "B" from namespace "A\A"
                    // if class "A\A\B" not found, it tries to autoload class "A\A\B"

      \A\B::foo();  // calls method "foo" of class "B" from namespace "A"
                    // if class "A\B" not found, it tries to autoload class "A\B"
      ?>
      ```

## 32. Handle Multiple Request Methods From a Controller Action?

- About

  Over the next three episodes, we'll review a number of refactors that are a bit more advanced. But first, we need to encounter a situation that necessitates the refactors. We'll use the example of a messy controller action that can respond to multiple request types.

- Things You'll Learn
  - Request Methods
  - Delete Forms

## 33. Build a Better Router

- About

  In this episode, we'll build a better router that can handle and respond to any form request type. However, because forms only natively support GET and POST, we'll need to use a hidden input field to spoof the request type.

- Things You'll Learn
  - Request Methods
  - Request Type Spoofing
  - Routing

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
