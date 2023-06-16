# PHP 8 Crash Course

- PHP 8 is now officially available. As part of this new release, not only will you benefit from performance improvements - thanks to the new JIT compiler - but you'll also enjoy useful new operators and types, attributes, match expressions, and so much more.

- If you're intrigued, hop in and we'll review everything you need to know.

## 01. How to Install PHP 8

- About

  Before we can play around, of course we must first download PHP 8. At the time of this writing, PHP 8 is not yet officially out. As such, we'll tap a custom [Homebrew](http://brew.sh/) formula to make the installation process as painless as possible. Alternatively, you might consider using Docker or Vagrant to create an isolated environment for testing PHP 8.

## 02. The Nullsafe Operator

- About

  First up on the agenda is the new [Nullsafe operator](https://wiki.php.net/rfc/nullsafe_operator). This operator - represented as a question mark - allows you to call a method on the result of any expression if it does not evaluate to null. It sounds confusing, but it really isn't. Let's have a look.

## 03. Match Expressions

- About

  Switch statements in PHP are useful, yet clunky. Think of the new [match expression](https://wiki.php.net/rfc/match_expression_v2) in PHP 8 as an improved switch. It's far more terse and flexible than its counterpart.

## 04. Constructor Property Promotion

- About

  Next up is [constructor property promotion](https://wiki.php.net/rfc/constructor_promotion), which allows you to remove much of the tedious class initialization boilerplate code that you likely write for every any that accepts a dependency.

## 05. $object::class

- About

  This next one is a small, but useful addition to PHP 8 that received [unanimous support](https://wiki.php.net/rfc/class_name_literal_on_object) during the voting stage. You now have the ability to use `::class` directly on an object. The result will be functionally identical to the result of `get_class()`. In PHP 7 and below, this functionality was limited to the class, itself.

## 06. Named Parameters

- About

  Next up, we have [named parameters](https://wiki.php.net/rfc/named_params). This new PHP 8 feature allows you to pass function arguments according to, not their order, but the parameter name, itself. Let's discuss the pros and cons of adopting named parameters/arguments in your own projects.

## 07. New String Helpers

- About

  It took a global pandemic for PHP to finally add a `str_contains` helper function, but it's finally here (along with a few others). In this episode, we'll review `str_contains()`, `str_starts_with()`, and `str_ends_with()`.

## 08. Weak Maps

- About

  Weak maps are effectively key value stores that allow for garbage collection. You won't reach for these often, but they're nonetheless an important tool to have in your belt.

## 09. Union and Pseudo Types

- About

  Next up, we'll discuss PHP 8's support for union types, as well as a new catch-all `mixed` pseudo-type. We can now - without resorting to docblocks - specify that a method parameter may accept multiple types.
