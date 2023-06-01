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

## 10. Separate Logic From the Template

## 11. Technical Check-in #1(With Quiz)

# 2. Dynamic Web Applications

## 12. Page Links

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
