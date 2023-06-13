# About

- The typical beginner, whether they realize it or not, first learns procedural programming. But, before too long, they level up. Suddenly, an entirely different paradigm is introduced: object-oriented programming. Little do they know that they'll spend years researching and learning exactly what it means to work with objects and messages.

- In this series, you'll be introduced to the core principles of object-oriented programming in PHP. We'll begin with the basic constructs and work our way up.

# 1. Constructs

## 1. Classes

- About

  Let's begin with an introduction to classes in PHP. I like to think of a class as a blueprint or template that defines the overall structure and behavior for some concept in your codebase.

- Class

  - Basic class definitions begin with the keyword `class`, followed by a class name, followed by a pair of curly braces which enclose the definitions of the properties and methods belonging to the class.

  - A class may contain its own `constants`, `variables` (called "properties"), and functions (called "methods").

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

  - Warning

    - Calling a non-static method statically throws an `Error`. Prior to PHP 8.0.0, this would generate a deprecation notice, and `$this` would be undefined.

  - Readonly classes

    - As of PHP 8.2.0, a class can be marked with the readonly modifier. Marking a class as readonly will add the `readonly modifier` to every declared property, and prevent the creation of `dynamic properties`. Moreover, it is impossible to add support for them by using the `AllowDynamicProperties` attribute. Attempting to do so will trigger a compile-time error.

      ```php
      <?php
      #[\AllowDynamicProperties]
      readonly class Foo {
      }

      // Fatal error: Cannot apply #[AllowDynamicProperties] to readonly class Foo
      ?>
      ```

    - As neither untyped, nor static properties can be marked with the readonly modifier, readonly classes cannot declare them either:

      ```php
      <?php
      readonly class Foo
      {
          public $bar;
      }

      // Fatal error: Readonly property Foo::$bar must have type
      ?>
      ```

      ```php
      <?php
      readonly class Foo
      {
          public static int $bar;
      }

      // Fatal error: Readonly class Foo cannot declare static properties
      ?>
      ```

    - A readonly class can be `extended` if, and only if, the child class is also a readonly class.

  - new

    - To create an instance of a class, the new keyword must be used. An object will always be created unless the object has a constructor defined that throws an `exception` on error. Classes should be defined before instantiation (and in some cases this is a requirement).

    - Note:

      - If there are no arguments to be passed to the class's constructor, parentheses after the class name may be omitted.

## 2. Objects

- About

  If a class is the blueprint, then an object is an instance (or implementation) of that blueprint. In this lesson, you'll learn how to create multiple instances of a class, how to define and set internal state, and how to declare static constructors that better reflect how you might speak in real life.

- Object Initialization ¶

  - To create a new object, use the `new` statement to instantiate a class:

    ```php
    <?php
    class foo
    {
        function do_foo()
        {
            echo "Doing foo.";
        }
    }

    $bar = new foo;
    $bar->do_foo();
    ?>
    ```

  - Converting to object ¶

    - If an object is converted to an object, it is not modified. If a value of any other type is converted to an object, a new instance of the `stdClass` built-in class is created. If the value was `null`, the new instance will be empty. An array converts to an object with properties named by keys and corresponding values. Note that in this case before PHP 7.2.0 numeric keys have been inaccessible unless iterated.

      ```php
      <?php
      $obj = (object) array('1' => 'foo');
      var_dump(isset($obj->{'1'})); // outputs 'bool(true)' as of PHP 7.2.0; 'bool(false)' previously
      var_dump(key($obj)); // outputs 'string(1) "1"' as of PHP 7.2.0; 'int(1)' previously
      ?>
      ```

    - For any other value, a member variable named scalar will contain the value.

      ```php
      <?php
      $obj = (object) 'ciao';
      echo $obj->scalar;  // outputs 'ciao'
      ?>
      ```

## 3. Inheritance

- About

  Inheritance allows one class to inherit the traits and behavior of another class. This should instantly make sense, in the same way that a child inherits characteristics from their parents. In this lesson, we'll review several examples of inheritance in action.

- Object Inheritance ¶

  - Inheritance is a well-established programming principle, and PHP makes use of this principle in its object model. This principle will affect the way many classes and objects relate to one another.

  - For example, when extending a class, the subclass inherits all of the public and protected methods, properties and constants from the parent class. Unless a class overrides those methods, they will retain their original functionality.

  - This is useful for defining and abstracting functionality, and permits the implementation of additional functionality in similar objects without the need to reimplement all of the shared functionality.

  - Private methods of a parent class are not accessible to a child class. As a result, child classes may reimplement a private method themselves without regard for normal inheritance rules. Prior to PHP 8.0.0, however, final and static restrictions were applied to private methods. As of PHP 8.0.0, the only private method restriction that is enforced is private final constructors, as that is a common way to "disable" the constructor when using static factory methods instead.

  - The `visibility` of methods, properties and constants can be relaxed, e.g. a `protected` method can be marked as `public`, but they cannot be restricted, e.g. marking a `public` property as `private`. An exception are constructors, whose visibility can be restricted, e.g. a `public` constructor can be marked as `private` in a child class.

  - Note:

    - Unless autoloading is used, the classes must be defined before they are used. If a class extends another, then the parent class must be declared before the child class structure. This rule applies to classes that inherit other classes and interfaces.

  - Note:

    - It is not allowed to override a read-write property with a `readonly property` or vice versa.

      ```php
      <?php

      class A {
          public int $prop;
      }
      class B extends A {
          // Illegal: read-write -> readonly
          public readonly int $prop;
      }
      ?>
      ```

  - **Example #1 Inheritance Example**

    ```php
    <?php

    class Foo
    {
        public function printItem($string)
        {
            echo 'Foo: ' . $string . PHP_EOL;
        }

        public function printPHP()
        {
            echo 'PHP is great.' . PHP_EOL;
        }
    }

    class Bar extends Foo
    {
        public function printItem($string)
        {
            echo 'Bar: ' . $string . PHP_EOL;
        }
    }

    $foo = new Foo();
    $bar = new Bar();
    $foo->printItem('baz'); // Output: 'Foo: baz'
    $foo->printPHP();       // Output: 'PHP is great'
    $bar->printItem('baz'); // Output: 'Bar: baz'
    $bar->printPHP();       // Output: 'PHP is great'

    ?>
    ```

- Return Type Compatibility with Internal Classes ¶

  - Prior to PHP 8.1, most internal classes or methods didn't declare their return types, and any return type was allowed when extending them.

  - As of PHP 8.1.0, most internal methods started to "tentatively" declare their return type, in that case the return type of methods should be compatible with the parent being extended; otherwise, a deprecation notice is emitted. Note that lack of an explicit return declaration is also considered a signature mismatch, and thus results in the deprecation notice.

  - If the return type cannot be declared for an overriding method due to PHP cross-version compatibility concerns, a ReturnTypeWillChange attribute can be added to silence the deprecation notice.

  - **Example #2 The overriding method does not declare any return type**

    ```php
    <?php
    class MyDateTime extends DateTime
    {
        public function modify(string $modifier) { return false; }
    }

    // "Deprecated: Return type of MyDateTime::modify(string $modifier) should either be compatible with DateTime::modify(string $modifier): DateTime|false, or the #[\ReturnTypeWillChange] attribute should be used to temporarily suppress the notice" as of PHP 8.1.0
    ?>
    ```

  - **Example #3 The overriding method declares a wrong return type**

    ```php
    <?php
    class MyDateTime extends DateTime
    {
        public function modify(string $modifier): ?DateTime { return null; }
    }

    // "Deprecated: Return type of MyDateTime::modify(string $modifier): ?DateTime should either be compatible with DateTime::modify(string $modifier): DateTime|false, or the #[\ReturnTypeWillChange] attribute should be used to temporarily suppress the notice" as of PHP 8.1.0
    ?>
    ```

  - **Example #4 The overriding method declares a wrong return type without a deprecation notice**

    ```php
    <?php
    class MyDateTime extends DateTime
    {
        /**
        * @return DateTime|false
        */
        #[\ReturnTypeWillChange]
        public function modify(string $modifier) { return false; }
    }

    // No notice is triggered
    ?>
    ```

## 4. Abstract Classes

- About

  An abstract class provides a template - or base - for any subclasses. In this lesson, we'll work through an example that demonstrates how, why, and when you might reach for an abstract class.

- Class Abstraction ¶

  - PHP has abstract classes and methods. Classes defined as abstract cannot be instantiated, and any class that contains at least one abstract method must also be abstract. Methods defined as abstract simply declare the method's signature; they cannot define the implementation.

  - When inheriting from an abstract class, all methods marked abstract in the parent's class declaration must be defined by the child class, and follow the usual `inheritance` and `signature compatibility` rules.

  - **Example #1 Abstract class example**

    ```php
    <?php
    abstract class AbstractClass
    {
        // Force Extending class to define this method
        abstract protected function getValue();
        abstract protected function prefixValue($prefix);

        // Common method
        public function printOut() {
            print $this->getValue() . "\n";
        }
    }

    class ConcreteClass1 extends AbstractClass
    {
        protected function getValue() {
            return "ConcreteClass1";
        }

        public function prefixValue($prefix) {
            return "{$prefix}ConcreteClass1";
        }
    }

    class ConcreteClass2 extends AbstractClass
    {
        public function getValue() {
            return "ConcreteClass2";
        }

        public function prefixValue($prefix) {
            return "{$prefix}ConcreteClass2";
        }
    }

    $class1 = new ConcreteClass1;
    $class1->printOut();
    echo $class1->prefixValue('FOO_') ."\n";

    $class2 = new ConcreteClass2;
    $class2->printOut();
    echo $class2->prefixValue('FOO_') ."\n";
    ?>
    ```

    - The above example will output:

      ```bash
      ConcreteClass1
      FOO_ConcreteClass1
      ConcreteClass2
      FOO_ConcreteClass2
      ```

  - **Example #2 Abstract class example**

    ```php
    <?php
    abstract class AbstractClass
    {
        // Our abstract method only needs to define the required arguments
        abstract protected function prefixName($name);

    }

    class ConcreteClass extends AbstractClass
    {

        // Our child class may define optional arguments not in the parent's signature
        public function prefixName($name, $separator = ".") {
            if ($name == "Pacman") {
                $prefix = "Mr";
            } elseif ($name == "Pacwoman") {
                $prefix = "Mrs";
            } else {
                $prefix = "";
            }
            return "{$prefix}{$separator} {$name}";
        }
    }

    $class = new ConcreteClass;
    echo $class->prefixName("Pacman"), "\n";
    echo $class->prefixName("Pacwoman"), "\n";
    ?>
    ```

    - The above example will output:

      ```bash
      Mr. Pacman
      Mrs. Pacwoman
      ```

## 5. Handshakes and Interfaces

- About

  Think of an interface as a class with no behavior. Instead, it describes the terms for a particular contract. Any class that signs this contract must adhere to those terms. Let's review this idea using the example of a newsletter signup.

- Object Interfaces ¶

  - Object interfaces allow you to create code which specifies which methods a class must implement, without having to define how these methods are implemented. Interfaces share a namespace with classes and traits, so they may not use the same name.

  - Interfaces are defined in the same way as a class, but with the `interface` keyword replacing the `class` keyword and without any of the methods having their contents defined.

  - In practice, interfaces serve two complementary purposes:

    - To allow developers to create objects of different classes that may be used interchangeably because they implement the same interface or interfaces. A common example is multiple database access services, multiple payment gateways, or different caching strategies. Different implementations may be swapped out without requiring any changes to the code that uses them.

    - To allow a function or method to accept and operate on a parameter that conforms to an interface, while not caring what else the object may do or how it is implemented. These interfaces are often named like `Iterable`, `Cacheable`, `Renderable`, or so on to describe the significance of the behavior.

  - Interfaces may define `magic methods` to require implementing classes to implement those methods.

  - Note:

    - Although they are supported, including `constructors` in interfaces is strongly discouraged. Doing so significantly reduces the flexibility of the object implementing the interface. Additionally, constructors are not enforced by inheritance rules, which can cause inconsistent and unexpected behavior.

  - implements ¶

    - To implement an interface, the `implements` operator is used. All methods in the interface must be implemented within a class; failure to do so will result in a fatal error. Classes may implement more than one interface if desired by separating each interface with a comma.

    - Warning

      - A class that implements an interface may use a different name for its parameters than the interface. However, as of PHP 8.0 the language supports named arguments, which means callers may rely on the parameter name in the interface. For that reason, it is strongly recommended that developers use the same parameter names as the interface being implemented.

    - Note:

      - Interfaces can be extended like classes using the `extends` operator.

    - Note:

      - The class implementing the interface must declare all methods in the interface with a `compatible signature`. A class can implement multiple interfaces which declare a method with the same name. In this case, the implementation must follow the `signature compatibility rules` for all the interfaces. So `covariance and contravariance` can be applied.

  - Constants ¶

    - It's possible for interfaces to have constants. Interface constants work exactly like `class constants`. Prior to PHP 8.1.0, they cannot be overridden by a class/interface that inherits them.

- Examples ¶

  - **Example #1 Interface example**

    ```php
    <?php

    // Declare the interface 'Template'
    interface Template
    {
        public function setVariable($name, $var);
        public function getHtml($template);
    }

    // Implement the interface
    // This will work
    class WorkingTemplate implements Template
    {
        private $vars = [];

        public function setVariable($name, $var)
        {
            $this->vars[$name] = $var;
        }

        public function getHtml($template)
        {
            foreach($this->vars as $name => $value) {
                $template = str_replace('{' . $name . '}', $value, $template);
            }

            return $template;
        }
    }

    // This will not work
    // Fatal error: Class BadTemplate contains 1 abstract methods
    // and must therefore be declared abstract (Template::getHtml)
    class BadTemplate implements Template
    {
        private $vars = [];

        public function setVariable($name, $var)
        {
            $this->vars[$name] = $var;
        }
    }
    ?>
    ```

  - **Example #2 Extendable Interfaces**

    ```php
    <?php
    interface A
    {
        public function foo();
    }

    interface B extends A
    {
        public function baz(Baz $baz);
    }

    // This will work
    class C implements B
    {
        public function foo()
        {
        }

        public function baz(Baz $baz)
        {
        }
    }

    // This will not work and result in a fatal error
    class D implements B
    {
        public function foo()
        {
        }

        public function baz(Foo $foo)
        {
        }
    }
    ?>
    ```

  - **Example #3 Variance compatibility with multiple interfaces**

    ```php
    <?php
    class Foo {}
    class Bar extends Foo {}

    interface A {
        public function myfunc(Foo $arg): Foo;
    }

    interface B {
        public function myfunc(Bar $arg): Bar;
    }

    class MyClass implements A, B
    {
        public function myfunc(Foo $arg): Bar
        {
            return new Bar();
        }
    }
    ?>
    ```

  - **Example #4 Multiple interface inheritance**

    ```php
    <?php
    interface A
    {
        public function foo();
    }

    interface B
    {
        public function bar();
    }

    interface C extends A, B
    {
        public function baz();
    }

    class D implements C
    {
        public function foo()
        {
        }

        public function bar()
        {
        }

        public function baz()
        {
        }
    }
    ?>
    ```

  - **Example #5 Interfaces with constants**

    ```php
    <?php
    interface A
    {
        const B = 'Interface constant';
    }

    // Prints: Interface constant
    echo A::B;


    class B implements A
    {
        const B = 'Class constant';
    }

    // Prints: Class constant
    // Prior to PHP 8.1.0, this will however not work because it was not
    // allowed to override constants.
    echo B::B;
    ?>
    ```

  - **Example #6 Interfaces with abstract classes**

    ```php
    <?php
    interface A
    {
        public function foo(string $s): string;

        public function bar(int $i): int;
    }

    // An abstract class may implement only a portion of an interface.
    // Classes that extend the abstract class must implement the rest.
    abstract class B implements A
    {
        public function foo(string $s): string
        {
            return $s . PHP_EOL;
        }
    }

    class C extends B
    {
        public function bar(int $i): int
        {
            return $i * 2;
        }
    }
    ?>
    ```

  - **Example #7 Extending and implementing simultaneously**

    ```php
    <?php

    class One
    {
        /* ... */
    }

    interface Usable
    {
        /* ... */
    }

    interface Updatable
    {
        /* ... */
    }

    // The keyword order here is important. 'extends' must come first.
    class Two extends One implements Usable, Updatable
    {
        /* ... */
    }
    ?>
    ```

## 6. Encapsulation

- About

  Encapsulation allows a class to provide signals to the outside world that certain internals are private and shouldn't be accessed. So at it's core, encapsulation is about communication.

- PHP RFC: Encapsulation

  - This RFC proposes the introduction of encapsulation to classes, interfaces and traits within a namespace.

  - Proposal

    - Since PHP 5.3 namespaces have been used as a tool to organise related pieces of functionality into named units. However it is often the case that not all of the functionality contained within a namespace is required to be exposed and accessible to other parts of the program, even if a well documented and complete API is presented a developer may still access the inner-most parts of the module.

    - With the application of encapsulation a developer trying to directly access functionality that was intended to only be used within the scope of the module (a helper class or utility function) will be denied this access, and it will serve as an indication that they are attempting to do something outside of the intended design.

    - This proposal is limited to the private visibility of classes, interfaces and traits, reusing the existing `private` keyword. There is plenty of room for future scope if the community decides that this type of functionality is desirable on the whole.

  - New Behaviour

    - Private classes can only be instantiated and extended within their defining namespace.
    - Private interfaces can only be implemented and extended within their defining namespace.
    - Private traits can only be extended and used in classes that are also defined within the same namespace.
    - Attempting to access a private class, interface or trait out of scope results in a fatal error.

  - Unchanged Behaviour

    - Outside of the new behaviour introduced using the `private` keyword, other behaviour remains untouched. For example, once a private class has been instantiated the object can be returned to a caller in any namespace, and the methods and properties of an are accessible just as they would be for a public class. Private classes and interfaces can still be used for parameter hinting in any namespace, and checks such as `implements` can be used with them.

  - Reflection

    - The following reflection methods have been implemented in the patch

      - ReflectionClass::isPublic()
      - ReflectionClass::isPrivate()
      - ReflectionClass::setAccessible()

  - Auto-loading

    - Private visibility is respected when auto-loading is triggered from an invalid namespace.

  - Examples

    - Instantiating a private class from an invalid scope

      ```php
      namespace Foo {
        private class Bar {}

        function giveMeBar()
        {
          return new Bar;
        }
      }

      $foobar = \Foo\giveMeBar(); // This is fine
      $foobar = new \Foo\Bar;     // This is a fatal error
      ```

    - Extending a private class from an invalid scope

      ```php
      namespace Foo {
        private class Bar {}
      }

      namespace Baz {
        class Qux extends \Foo\Bar {} // This is a fatal error
      }
      ```

    - Implementing a private interface from an invalid scope

      ```php
      namespace Foo {
        private interface Bar {}
      }

      namespace Baz {
        class Qux implements \Foo\Bar {} // This is a fatal error
      }
      ```

## 7. Object Composition and Abstractions

- About

  Let's move on to object composition. To break it down into the simplest of terms, composition is when one object holds a pointer to another object. This allows us to construct complex functionality by combining various types.

- **Reusing Implementation – a Walk-through of Inheritance, Composition, and Delegation**

  - Treading Inheritance’s Path – Simplicity vs Basetype/Subtype Issues

    - It shouldn’t be breaking news that the first code reuse approach I plan to put in the spotlight first is the most overused and misused of all, Inheritance. But I don’t want to be a sadist and bore you to tears (and myself, of course) explaining how to get a nice Dog subclass up and running by inheriting from Animal (ouch!). Rather, I’ll be a little more realistic and we’ll sink our teeth into a naïve, yet functional, PDO adapter. Here we go:

    ```php
    <?php
    namespace LibraryDatabase;

    interface DatabaseAdapterInterface
    {
        public function executeQuery($sql, array $parameters = array());
    }
    ```

    ```php
    <?php
    namespace LibraryDatabase;

    class PdoAdapter extends PDO implements DatabaseAdapterInterface
    {
        protected $statement;

        public function __construct($dsn, $username = null, $password = null, array $options = array())
        {
            // fail early if the PDO extension is not loaded
            if (!extension_loaded("pdo")) {
                throw new InvalidArgumentException(
                    "This adapter needs the PDO extension to be loaded.");
            }
            // check if a valid DSN has been passed in
            if (!is_string($dsn) || empty($dsn)) {
                throw new InvalidArgumentException(
                    "The DSN must be a non-empty string.");
            }
            // try to create a valid PDO object
            try {
                parent::__construct($dsn, $username, $password,
                    $options);
                $this->setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION);
                $this->setAttribute(PDO::ATTR_EMULATE_PREPARES,
                    false);

            }
            catch (PDOException $e) {
                throw new RunTimeException($e->getMessage());
            }
        }

        public function executeQuery($sql, array $parameters = array())
        {
            try {
              $this->statement = $this->prepare($sql);
              $this->statement->execute($parameters);
              return $this->statement->fetchAll(PDO::FETCH_CLASS,
                  "stdClass");

            }
            catch (PDOException $e) {
                throw new RunTimeException($e->getMessage());
            }
        }
    }
    ```

    - When it comes to creating a quick and dirty adapter that just adds some extra functionality to the one provided by the `PDO` class, Inheritance is indeed a pretty tempting path. In this case, the adapter performs some basic validation on the inputted database arguments and its `executeQuery()` method allows us to run parameterized queries via an easily consumable API. The following snippet demonstrates how to drop the adapter into client code to pull in a few users from the database:

      ```php
      <?php
      use LibraryLoaderAutoloader,
          LibraryDatabasePdoAdapter;

      require_once __DIR__ . "/Library/Loader/Autoloader.php";
      $autoloader = new Autoloader;
      $autoloader->register();

      $adapter = new PdoAdapter("mysql:dbname=mydatabase",
          "myfancyusername", "myhardtoguesspassword");

      $guests = $adapter->executeQuery("SELECT * FROM users WHERE role = :role", array(":role" => "Guest"));

      foreach($guests as $guest) {
          echo $guest->name . " " . $guest->email . "<br>";
      }
      ```

    - There are no smelly signs of any “incidental” breakages of the LSP, meaning that any instance of `PdoAdapter` could be safely swapped out at runtime by a base `PDO` object without complaints from the client code, and the adapter has been blessed with all the legacy functionality encapsulated by its parent. Can we dare to ask for a better deal?

    - Admittedly, there’s a catch. While not explicit, `PdoAdapter` is actually exposing to the outside world the whole verbose PDO API, plus the one implemented on it’s own. There might be occasions where we want to avoid this, even if the “IS-A” relation between `PdoAdapter` and `PDO` is neatly maintained.

    - We could appeal to the wisdom of the mantra “favor Composition over Inheritance” in such situations and effectively shift into the seas of Composition. In doing so, we would be effectively reusing `PDO`’s implementation, but without having to deal with its entire API. Better yet, since there wouldn’t be a “IS-A” relationship, but instead a “HAS-A” one between the corresponding adapter and the `PDO` class, we’d be also satisfying our purist OOP instincts. `Encapsulation` would keep its pristine shell intact.

    - Of course, one nice way to understand the inner workings of this approach is by setting up a concrete example. Let’s tweak the previous PdoAdapter class to honor the commandments of Composition.

  - Composition over Inheritance – of Adapters, Adaptees, and Other Funny Facts

    - Contrary to popular opinion, it’s ridiculously easy to implement a PDO adapter that rests on the pillars of Composition. Furthermore, the whole refactoring would be limited to just creating a simple wrapper which would inject a native `PDO` object into the constructor. Once again, a hands-on example is the best teacher when it comes to understanding the driving logic of the process:

      ```php
      <?php
      namespace LibraryDatabase;

      interface DatabaseAdapterInterface
      {
          public function executeQuery($sql, array $parameters = array());
      }
      ```

      ```php
      <?php
      namespace LibraryDatabase;

      class PdoAdapter implements DatabaseAdapterInterface
      {
          protected $pdo;
          protected $statement;

          public function __construct(PDO $pdo)
          {
              $this->pdo = $pdo;
              $this->pdo->setAttribute(PDO::ATTR_ERRMODE,
                  PDO::ERRMODE_EXCEPTION);
              $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,
                  false);
          }

          public function executeQuery($sql, array $parameters = array())
          {
              try {
                $this->statement = $this->pdo->prepare($sql);
                $this->statement->execute($parameters);
                return $this->statement->fetchAll(PDO::FETCH_CLASS,
                    "stdClass");
              }
              catch (PDOException $e) {
                  throw new RunTimeException($e->getMessage());
              }
          }
      }
      ```

    - While the refactored version of the adapter follows in general the formal definition of the `Adapter pattern`, the adaptee passed along into the adapter’s internals is, in this case, a concrete implementation rather than an abstraction. Considering that we’re attempting to design a slimmed down API for a `PDO` object, it doesn’t hurt to be pragmatic and inject the object directly in question without having to go through the hassle of defining an extra interface. If you feel a little more comfortable picking up the interface-based approach, just go ahead and stick to it all the way.

    - Leaving out of the picture those subtle implementation details, by far the most relevant thing to point out is the `PdoAdapter` class is now is a less verbose creature. Using Composition, it hides the whole PDO API from the outside world by exposing only its `executeQuery()` method to client code. Although naïve, the example raises a few points worth noting. First, the burden of dealing with potentially dangerous class hierarchies, where subtypes might behave wildly different from their base types blowing away application flow, has quietly vanished in thin air. Second, not only now is the adapter’s API less bloated, it declares an explicit dependency on a `PDO` implementation, which makes it easier to see from the outside the collaborator it needs to do its thing.

    - Yet this slew of benefits come with a not-so-hidden cost: in more realistic situations, it might be harder to create “composed” adapters than it is to create “inherited” ones. The correct path to tread will vary from case to case; be rational and choose the one that fits your requirements the best.

    - If you’re wondering how to get things rolling with the refactored PdoAdapter class, the following example should be instructive:

      ```php
      <?php
      $pdo = new PDO("mysql:dbname=mydatabase",
          "myfancyusername", "myhardtoguesspassword");
      $adapter = new PdoAdapter($pdo);

      $guests = $adapter->executeQuery("SELECT * FROM users WHERE role = :role", array(":role" => "Guest"));

      foreach($guests as $guest) {
          echo $guest->name . " " . $guest->email . "<br>";
      }
      ```

    - By now we’ve seen at a very broad level two common approaches that can be employed for reusing implementation. So, what comes next? Well, I promised to dig deeper into the niceties of Delegation, too. While admittedly Composition is an implicit form of Delegation, in the earlier example the delegation link was set by declaring a dependency on a PDO implementation in the constructor.

    - It’s feasible, however, to get a decent delegation mechanism up and running by using one or multiple factory methods, even though this misses much of the advantages of decoupling interface from implementation. Regardless, it’s worth looking at this approach as it comes in helpful for building PDO adapters capable of lazy connections to the database.

  - Deferring Database Trips through Delegation

    - Can anything be more delightful than delaying an expensive database trip to the last minute? Avoiding it completely would certainly be better, which is the prime reason why cache system live and breath. But unfortunately, we just can’t have it all sometimes and we need to settle ourselves by designing PDO adapters that encapsulate this nifty ability inside the boundaries of a factory method.

    - Delegation is a simple yet powerful pattern that allows to implement this feature without much hassle. If we would turn our attention to the previous `PdoAdapter` class and make it exploit the benefits of Delegation, it would look as follows:

    ```php
    <?php
    namespace LibraryDatabase;

    interface DatabaseAdapterInterface
    {
        public function connect();

        public function disconnect();

        public function executeQuery($sql, array $parameters = array());
    }
    ```

    ```php
    <?php
    namespace LibraryDatabase;

    class PdoAdapter implements DatabaseAdapterInterface
    {
        protected $config = array();
        protected $connection;
        protected $statement;

        public function __construct($dsn, $username = null, $password = null, array $options = array())
        {
            // fail early if the PDO extension is not loaded
            if (!extension_loaded("pdo")) {
                throw new InvalidArgumentException(
                    "This adapter needs the PDO extension to be loaded.");
            }
            // check if a valid DSN has been passed in
            if (!is_string($dsn) || empty($dsn)) {
                throw new InvalidArgumentException(
                    "The DSN must be a non-empty string.");
            }
            $this->config = compact("dsn", "username",
                "password", "options");
        }

        public function connect()
        {
            if ($this->connection) {
                return;
            }
            try {
                $this->connection = new PDO(
                    $this->config["dsn"],
                    $this->config["username"],
                    $this->config["password"],
                    $this->config["options"]
                );
                $this->connection->setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(
                    PDO::ATTR_EMULATE_PREPARES, false);
            }
            catch (PDOException $e) {
                throw new RunTimeException($e->getMessage());
            }
        }

        public function disconnect()
        {
            $this->connection = null;
        }

        public function executeQuery($sql, array $parameters = array())
        {
            $this->connect();
            try {
              $this->statement = $this->connection->prepare($sql);
              $this->statement->execute($parameters);
              return $this->statement->fetchAll(PDO::FETCH_CLASS,
                  "stdClass");
            }
            catch (PDOException $e) {
                throw new RunTimeException($e->getMessage());
            }
        }
    }
    ```

    - If you’ve ever had the chance to craft your own PDO masterpiece from scratch, or if you’ve just reused one of the heap available in the wild, the underlying logic of the above adapter should be pretty easy to grasp. Unquestionably, its most engaging facet is the implementation of the `connect()` method, as its responsibility is to create a `PDO` object on request which is then used in turn to dispatch queries against the database.

    - While admittedly this is pretty dull and boring, it’s helpful for showing how to use a sort of “hard-coded” Delegation in the implementation of adapters which are clever enough for triggering lazy connections to the database. Furthermore, the example below demonstrates how to put the adapter to use:

      ```php
      <?php
      $adapter = new PdoAdapter("mysql:dbname=mydatabase",
          "myfancyusername", "myhardtoguespassword");

      $guests = $adapter->executeQuery("SELECT * FROM users WHERE role = :role", array(":role" => "Guest"));

      foreach($guests as $guest) {
          echo $guest->name . " " . $guest->email . "<br>";
      }
      ```

    - Call me an unbearable pedantic if you want to, but consuming the adapter is actually a simple process, especially when analyzed from the client code’s standpoint. The major pitfall is that the adapter hides a dependency. This introduces a nasty coupling, hence making the whole implementation a little bit dirty. On the flip side, the adapter’s most appealing virtue rests with its capability for calling the database only when the situation warrants. Naturally, this sort of trade off can be worked out pretty easily by injecting a factory in the adapter, which would be charged with creating a `PDO` object when needed.

    - Even though this approach effectively is the best of both worlds, since it actively promotes the use of Dependency Injection while still employing Delegation, in my view it is somewhat overkill, at least in this case in particular.

  - Closing Thoughts

    - I have to admit that it’s rather challenging to come to a judgement on the flaws and niceties exposed by Inheritance, Composition and Delegation without falling into a shallow, shy analysis. Even so, taking the plunge is definitively worthwhile considering each approach is a central pillar of the OOP paradigm.

    - Moreover, while in this case I intentionally did an isolated “per approach” evaluation, something that hopefully was instructive in the end, it’s possible to wire up all the approaches together to implement more efficient code reuse strategies. There’s no mutual exclusion here.

    - Needless to say, it doesn’t make much sense to pile them up blindly just because you can. In all cases, be conscious and make sure to narrow their usage to the context you’re dealing with.

- Traits ¶

  - PHP implements a way to reuse code called Traits.

  - Traits are a mechanism for code reuse in single inheritance languages such as PHP. A Trait is intended to reduce some limitations of single inheritance by enabling a developer to reuse sets of methods freely in several independent classes living in different class hierarchies. The semantics of the combination of Traits and classes is defined in a way which reduces complexity, and avoids the typical problems associated with multiple inheritance and Mixins.

  - A Trait is similar to a class, but only intended to group functionality in a fine-grained and consistent way. It is not possible to instantiate a Trait on its own. It is an addition to traditional inheritance and enables horizontal composition of behavior; that is, the application of class members without requiring inheritance.

  - **Example #1 Trait example**

    ```php
    <?php
    trait ezcReflectionReturnInfo {
        function getReturnType() { /*1*/ }
        function getReturnDescription() { /*2*/ }
    }

    class ezcReflectionMethod extends ReflectionMethod {
        use ezcReflectionReturnInfo;
        /* ... */
    }

    class ezcReflectionFunction extends ReflectionFunction {
        use ezcReflectionReturnInfo;
        /* ... */
    }
    ?>
    ```

  - Precedence ¶

    - An inherited member from a base class is overridden by a member inserted by a Trait. The precedence order is that members from the current class override Trait methods, which in turn override inherited methods.

    - **Example #2 Precedence Order Example**

      - An inherited method from a base class is overridden by the method inserted into MyHelloWorld from the SayWorld Trait. The behavior is the same for methods defined in the MyHelloWorld class. The precedence order is that methods from the current class override Trait methods, which in turn override methods from the base class.

      ```php
      <?php
      class Base {
          public function sayHello() {
              echo 'Hello ';
          }
      }

      trait SayWorld {
          public function sayHello() {
              parent::sayHello();
              echo 'World!';
          }
      }

      class MyHelloWorld extends Base {
          use SayWorld;
      }

      $o = new MyHelloWorld();
      $o->sayHello();
      ?>
      ```

      - The above example will output:

        ```bash
        Hello World!
        ```

    - **Example #3 Alternate Precedence Order Example**

      ```php
      <?php
      trait HelloWorld {
          public function sayHello() {
              echo 'Hello World!';
          }
      }

      class TheWorldIsNotEnough {
          use HelloWorld;
          public function sayHello() {
              echo 'Hello Universe!';
          }
      }

      $o = new TheWorldIsNotEnough();
      $o->sayHello();
      ?>
      ```

      - The above example will output:

        ```bash
        Hello Universe!
        ```

  - Multiple Traits ¶

    - Multiple Traits can be inserted into a class by listing them in the use statement, separated by commas.

    - **Example #4 Multiple Traits Usage**

      ```php
      <?php
      trait Hello {
          public function sayHello() {
              echo 'Hello ';
          }
      }

      trait World {
          public function sayWorld() {
              echo 'World';
          }
      }

      class MyHelloWorld {
          use Hello, World;
          public function sayExclamationMark() {
              echo '!';
          }
      }

      $o = new MyHelloWorld();
      $o->sayHello();
      $o->sayWorld();
      $o->sayExclamationMark();
      ?>
      ```

      - The above example will output:

        ```bash
        Hello World!
        ```

  - Conflict Resolution ¶

    - If two Traits insert a method with the same name, a fatal error is produced, if the conflict is not explicitly resolved.

    - To resolve naming conflicts between Traits used in the same class, the `insteadof` operator needs to be used to choose exactly one of the conflicting methods.

    - Since this only allows one to exclude methods, the `as` operator can be used to add an alias to one of the methods. Note the `as` operator does not rename the method and it does not affect any other method either.

    - **Example #5 Conflict Resolution**

      - In this example, Talker uses the traits A and B. Since A and B have conflicting methods, it defines to use the variant of smallTalk from trait B, and the variant of bigTalk from trait A.

      - The Aliased_Talker makes use of the as operator to be able to use B's bigTalk implementation under an additional alias talk.

      ```php
      <?php
      trait A {
          public function smallTalk() {
              echo 'a';
          }
          public function bigTalk() {
              echo 'A';
          }
      }

      trait B {
          public function smallTalk() {
              echo 'b';
          }
          public function bigTalk() {
              echo 'B';
          }
      }

      class Talker {
          use A, B {
              B::smallTalk insteadof A;
              A::bigTalk insteadof B;
          }
      }

      class Aliased_Talker {
          use A, B {
              B::smallTalk insteadof A;
              A::bigTalk insteadof B;
              B::bigTalk as talk;
          }
      }
      ?>
      ```

  - Changing Method Visibility ¶

    - Using the `as` syntax, one can also adjust the visibility of the method in the exhibiting class.

    - **Example #6 Changing Method Visibility**

      ```php
      <?php
      trait HelloWorld {
          public function sayHello() {
              echo 'Hello World!';
          }
      }

      // Change visibility of sayHello
      class MyClass1 {
          use HelloWorld { sayHello as protected; }
      }

      // Alias method with changed visibility
      // sayHello visibility not changed
      class MyClass2 {
          use HelloWorld { sayHello as private myPrivateHello; }
      }
      ?>
      ```

  - Traits Composed from Traits ¶

    - Just as classes can make use of traits, so can other traits. By using one or more traits in a trait definition, it can be composed partially or entirely of the members defined in those other traits.

    - **Example #7 Traits Composed from Traits**

      ```php
      <?php
      trait Hello {
          public function sayHello() {
              echo 'Hello ';
          }
      }

      trait World {
          public function sayWorld() {
              echo 'World!';
          }
      }

      trait HelloWorld {
          use Hello, World;
      }

      class MyHelloWorld {
          use HelloWorld;
      }

      $o = new MyHelloWorld();
      $o->sayHello();
      $o->sayWorld();
      ?>
      ```

      - The above example will output:

        ```bash
        Hello World!
        ```

  - Abstract Trait Members ¶

    - Traits support the use of abstract methods in order to impose requirements upon the exhibiting class. Public, protected, and private methods are supported. Prior to PHP 8.0.0, only public and protected abstract methods were supported.

    - Caution

      - A concrete class fulfills this requirement by defining a concrete method with the same name; its signature may be different.

    - **Example #8 Express Requirements by Abstract Methods**

      ```php
      <?php
      trait Hello {
          public function sayHelloWorld() {
              echo 'Hello'.$this->getWorld();
          }
          abstract public function getWorld();
      }

      class MyHelloWorld {
          private $world;
          use Hello;
          public function getWorld() {
              return $this->world;
          }
          public function setWorld($val) {
              $this->world = $val;
          }
      }
      ?>
      ```

  - Static Trait Members ¶

    - Traits can define static variables, static methods and static properties.

    - Note:

      - As of PHP 8.1.0, calling a static method, or accessing a static property directly on a trait is deprecated. Static methods and properties should only be accessed on a class using the trait.

    - **Example #9 Static Variables**

      ```php
      <?php
      trait Counter {
          public function inc() {
              static $c = 0;
              $c = $c + 1;
              echo "$c\n";
          }
      }

      class C1 {
          use Counter;
      }

      class C2 {
          use Counter;
      }

      $o = new C1(); $o->inc(); // echo 1
      $p = new C2(); $p->inc(); // echo 1
      ?>
      ```

    - **Example #10 Static Methods**

      ```php
      <?php
      trait StaticExample {
          public static function doSomething() {
              return 'Doing something';
          }
      }

      class Example {
          use StaticExample;
      }

      Example::doSomething();
      ?>
      ```

    - **Example #11 Static Properties**

      ```php
      <?php
      trait StaticExample {
          public static $static = 'foo';
      }

      class Example {
          use StaticExample;
      }

      echo Example::$static;
      ?>
      ```

  - Properties ¶

    - Traits can also define properties.

    - **Example #12 Defining Properties**

      ```php
      <?php
      trait PropertiesTrait {
          public $x = 1;
      }

      class PropertiesExample {
          use PropertiesTrait;
      }

      $example = new PropertiesExample;
      $example->x;
      ?>
      ```

    - If a trait defines a property then a class can not define a property with the same name unless it is compatible (same visibility and type, readonly modifier, and initial value), otherwise a fatal error is issued.

      - **Example #13 Conflict Resolution**

        ```php
        <?php
        trait PropertiesTrait {
            public $same = true;
            public $different1 = false;
            public bool $different2;
            public bool $different3;
        }

        class PropertiesExample {
            use PropertiesTrait;
            public $same = true;
            public $different1 = true; // Fatal error
            public string $different2; // Fatal error
            readonly public bool $different3; // Fatal error
        }
        ?>
        ```

  - Constants ¶

    - Traits can, as of PHP 8.2.0, also define constants.

    - **Example #14 Defining Constants**

      ```php
      <?php
      trait ConstantsTrait {
          public const FLAG_MUTABLE = 1;
          final public const FLAG_IMMUTABLE = 5;
      }

      class ConstantsExample {
          use ConstantsTrait;
      }

      $example = new ConstantsExample;
      echo $example::FLAG_MUTABLE; // 1
      ?>
      ```

    - If a trait defines a constant then a class can not define a constant with the same name unless it is compatible (same visibility, initial value, and finality), otherwise a fatal error is issued.

      - **Example #15 Conflict Resolution**

        ```php
        <?php
        trait ConstantsTrait {
            public const FLAG_MUTABLE = 1;
            final public const FLAG_IMMUTABLE = 5;
        }

        class ConstantsExample {
            use ConstantsTrait;
            public const FLAG_IMMUTABLE = 5; // Fatal error
        }
        ?>
        ```

  - User Contributed Notes

    - Unlike inheritance; if a trait has static properties, each class using that trait has independent instances of those properties.

      - Example using parent class:

        ```php
        <?php
        class TestClass {
            public static $_bar;
        }
        class Foo1 extends TestClass { }
        class Foo2 extends TestClass { }
        Foo1::$_bar = 'Hello';
        Foo2::$_bar = 'World';
        echo Foo1::$_bar . ' ' . Foo2::$_bar; // Prints: World World
        ?>
        ```

      - Example using trait:

        ```php
        <?php
        trait TestTrait {
            public static $_bar;
        }
        class Foo1 {
            use TestTrait;
        }
        class Foo2 {
            use TestTrait;
        }
        Foo1::$_bar = 'Hello';
        Foo2::$_bar = 'World';
        echo Foo1::$_bar . ' ' . Foo2::$_bar; // Prints: Hello World
        ?>
        ```

## 8. Value Objects and Mutability

- About

  A value object is an object whose equality is determined by its data (or value) rather than any particular identity. To illustrate this, imagine three five dollar bills resting on a table. Does one bill have a unique identity compared to the other two? From our perspective, no. Five dollars is five dollars regardless of which bill you choose. However, compare this with two human beings who have the same first and last name. Are they identical, or does each person have a unique identity? Of course in this case, the latter is the correct answer.

- Value Objects

  - Value Objects are objects that are considered equal based on their values and not on identity.

    - For the sake of having an example, let’s say that our domain is ordering takeaway food for delivery. So within this we have the concept of a Takeaway as a place we can order food from. Since that is what we call them here even if they only deliver food, for, er, reasons.

  - Typically we would model this with an entity and not a value object. This does indeed fit well since equality between two takeaways is not determined by value.

    - For now, let's assume the only property they have are their names. If we have two takeaways with the same name they are not the same takeaway:

    ```php
    new Takeaway('Thai Tantic') != new Takeaway('Thai Tantic');
    ```

    - A takeaway that changes its name can still be the same takeaway:

      ```php
      $takeaway = new Takeaway('Wok around the clock');
      $takeaway->changeName('Wok this way');
      ```

  - So if we are deciding whether they are equal we have some identity beyond just values such as its name.
  - If we consider just the name itself though then two names are the same if they are the same value. This is clearly true with strings:

    ```php
    'Lord of the Fries' == 'Lord of the Fries';
    'Man Fryday' != 'The Codfather';
    ```

  - If we created an object to encapsulate the name then this needs not have identity but can just be consider equal if the value is the same:

    ```php
    new TakeawayName('Just Falafs')
      == new TakeawayName('Just Falafs');
    new TakeawayName('Abra Kebabra')
        != new TakeawayName('Jason Donnervan');
    ```

  - So if we want to model the Takeaway's name as an object then a value object is a good fit. Some value objects, such as the TakeawayName are about single values but trying to focus on the benefits of making that an object are perhaps a little misleading. Instead let's look at where we might want a value object to have more than one property.

  - So what other properties might our Takeaway entity have if it just stores them as primitive values? One important domain concept is the area that they will deliver to. For now let’s say assume a simplistic concept of this where it is determined by the location and a distance from that location. This will then form a circle which they will deliver within. The distance can be provided in kilometers or miles as well so we will need to know which it is. So we have the following:

    ```php
    class Takeaway
    {
        //...
        private $long;
        private $lat;
        private $distanceQuantity;
        private $distanceUnits;
    }
    ```

  - So let’s consider the distance. This is made up of two values, the unit of measurement and the amount of that measurement. The amount alone e.g. 6 is not a distance. The unit of distance e.g. km is not a distance. 6 km is a distance.

  - Both need to be equal for a distance to be considered equal:

    ```
    5km == 5km
    5km != 5cm
    5Km != 8km
    ```

  - So using primitives as two separate fields in the Takeaway entity is not fulling capturing the connection between these values. It is possible to change just the unit or just the quantity which does not seem like the correct behaviour. Instead we can extract an object that represents a distance, then we can change the whole distance object instead.

    ```php
    class Distance
    {
        private $quantity;
        private $unit;

        public function __construct($quantity, $unit)
        {
            $this->quantity = $quantity;
            $this->unit = $unit;
        }

        public function equals(Distance $toCompare)
        {
            return $this->quantity == $toCompare->quantity
              && $this->unit == $toCompare->unit;
        }
    }

    class Takeaway
    {
        //...
        private $long;
        private $lat;
        /**
        * @var Distance
        */
        private $distance;
    }
    ```

  - Likewise lat and long as separate properties don’t seem right, what we are really interested in is the location they determine. So let’s make that an object as well and make the reason we are interested in these values more explicit in our model.

    ```php
    class Location
    {
        private $long;
        private $lat;

        public function __construct($long, $lat)
        {
            $this->long = $long;
            $this->lat = $lat;
        }

        public function equals(Location $toCompare)
        {
            return $this->long == $toCompare->long
              && $this->lat == $toCompare->lat;
        }
    }

    class Takeaway
    {
        //...
        /**
        * @var Location
        */
        private $location;

        /**
        * @var Distance
        */
        private $distance;
    }
    ```

  - So value objects need not wrap a single primitive value. As well as this, value objects do not need to just contain primitives. What we are really interested in here is the area the company are willing to deliver to. The distance and location do not capture and make explicit this concept in out code. So let’s extract an object that represents the area covered. This can be made up of the location and distance value objects and not have any primitive values itself.

    ```php
    class DeliveryArea
    {
        private $location;
        private $radius;

        public function __construct(Location $location, Distance $radius)
        {
            $this->location = $location;
            $this->radius = $radius;
        }

        public function equals(DeliveryArea $toCompare)
        {
            return $this->location->equals($toCompare->location) && $this->radius->equals($toCompare->radius);
        }
    }

    class Takeaway
    {
        //...
        /**
        * @var DeliveryArea
        */
        private $areaCovered;
    }
    ```

  - Going back to the start again, these are value objects because there equality is determined by values and not by identity. The area covered still has no identity, we can swap it with another object with the same values without any issues. None of this says anything about behviour though; being a value object does not mean having no behaviour and just values.

  - So if we have a location and we want to find out if the company will deliver to it then we can ask the company object:

    ```php
    class Takeaway
    {
        //...
        /**
        * @var DeliveryArea
        */
        private $areaCovered;

        public function deliversTo(Location $location)
        {
          //determine if location falls within the area covered.
        }
    }
    ```

  - This method could calculate whether the location falls in the area itself but it would be simpler to just ask the Area object if the location falls in it:

    ```php
    class Takeaway
    {
        //...
        /**
        * @var DeliveryArea
        */
        private $areaCovered;

        public function deliversTo(Location $location)
        {
          return $this->areaCovered->includes($location);
        }
    }
    ```

  - Not only can the value object have behaviour but it attracts it. It is better for the DeliveryArea to decide whether the Location is included or not than have the Takeaway reach into the DeliveryArea to get its values and make the decision. This breaks encapsulation and by making it a method on the DeliveryArea it can be called from elsewhere. Putting the logic involved in checking in the Takeaway ties it to the wrong object.

  - So our company object now just has an AreaCovered object and a method that delegates to it for deciding if a location is within it. One thing that stands out here is that the company no longer knows anything about what that Area is or what the location is. When we started they were tied to lat, long, and a radius. Should alternative ways of identifying locations and areas - e.g. a list of postcodes that is covered then nothing needs changing in the company object to support this. Different implementations of the Location and AreaCovered objects could be used for this. We could extract interfaces for Location and AreaCovered and have different implementations without changing the Takeaway entity at all.

  - This encapsulation of data and polymorphism are the benefits of OO. If we just had the company object with primitives and that had the logic of deciding is a location was covered then supporting different area and location types would be much more difficult. We have introduced more objects, where each one is in itself very simple.

  - As well as this, the company object’s level of abstraction is higher now. We can see that it has an area that is covered and that we can find out whether a location falls in it. For many purposes this may be all we need to know when reading the code. We need not concern ourselves with the detail of how these things are implemented. Without this level of abstraction we would see that a company has a latitude, a longitude, a distance amount and a distance unit and some logic around these value. This tells us too much about the detail and not enough about the purpose and this will only get worse if we want to support more ways of representing these things.

  So value objects are useful for encapsulating data and exposing related behavior. Well, yes, but that’s not specific to value objects that is Object Orientation.

  - So what about immutability and validation? Well they are not unimportant but they are not what value objects are primarily about. Objects are about encapsulation and polymorphism. Value objects are the subset of objects where equality is determined by value and not identity.

- **What is the difference between Entities and Value Objects?**

  - Table of contents:

    1. Entities versus Value Objects
    2. How to identify Value Objects?
    3. Why is the distinction between Value Objects and Entity Objects important?
    4. Conclusion

    As you begin to delve deeper and deeper into the world of computer programming you start to uncover lots and lots of new theories and concepts.

    One such idea that isn’t intuitively obvious is Value Objects. A Value Object is an important concept in Domain Driven Design (DDD).

    For this article you don’t have to worry about Domain Driven Design or any of the related concepts as I’m going to be purely focusing on Value Objects. However, hopefully this is the first step towards a better understand of Domain Driven Design in general.

    Note: I’m assuming you have a good understanding of Object Oriented Programming. If not, you will probably want to read up on that before reading this article.

  - Entities versus Value Objects

    In Object Oriented Programming, we represent related attributes and methods as an Object.

    So for example, a Person could be an Object within our application. A person will have a name, email address and password as well as many other attributes. Within our database this person is represented by an id. This means that the person could change their name, email and password but it would still be the same person. When an object can change it’s attributes but remain the same object we call it an Entity. An Entity is mutable because it can change it’s attributes without changing the identity of the object. The Entity object will maintain the identity because it has an id in the database.

    Imagine that our application allows the person to track their current location. When the person is able to successfully connect to the internet and authenticate with our application a new Location object is created. This Location object has attributes for longitude and latitude. The Location object is a Value Object because we don’t care about the specific instance of the object we only care that it is a location.

    When the person changes location, we don’t have to update the Location object, we can simply create a new Location object. The Location object never changes it’s attributes from the moment it is created until the moment it is destroyed. When an object’s attributes cannot be changed, it is known as immutable.

    Another important distinction is, Value Objects equality is not based upon identity. So for example, when you create two Location objects with the same longitude and latitude attributes those two objects will be equal to one another. The Person object on the other hand does base equality on identity because it is a single representation with an id. If you had two people with the exact same name, they would not be the same person.

  - How to identify Value Objects?

    So hopefully you can see that we can generally make the distinction between an Entity and a Value Object when an object is represented with an id.

    An Entity’s attributes can change, but it remains the same representation within our system because of it’s unique identifier. Whereas a Value Object is a single instance of an object that is created and then destroyed. We don’t care about a specific instance of a Value Object and we can’t change it’s attributes.

    So how do you know when to use an Entity and when to use a Value Object? Well the decision really comes down to the context of the application.

    Imagine that in the example from earlier, our application is not just a generic social application, it is actually Foursquare. Now every individual Location object does have a unique identifier because many different users can checkin to that location over time. Now the Location object is an Entity, not a Value Object.

    On the other hand, imagine that we are the owner of a power plant that records activity around it’s security fence. The security fence has many locations where activity is recorded for monitoring purposes. Each location around the fence is an Entity because we care about recording activity at those specific locations. Whenever a suspicious person walks past one of our locations an incident is recorded in the database. In this example, a person is a Value Object because we don’t care about any particular person, we only care that a person triggered one of the security locations.

    So whether an object is an Entity or a Value Object really depends on the context of how you are using it within your application. Generally speaking objects like location, dates, numbers or money will nearly always be Value Objects, and objects like people, products, files or sales will nearly always be entities.

  - Why is the distinction between Value Objects and Entity Objects important?

    You are probably thinking, “why is the distinction between Value Objects and Entity Objects important?”.

    Well it’s actually really quite important for a number of reasons.

    Firstly, when you have two Entities with the same attributes, these two objects are not the same because they have two different identities. However, when you have two Value Objects with the same values, these two objects do have equality and can therefore can be interchanged freely. When you can substitute one object for another, the object is a Value object (in other words, the value is in the object, rather than the identity of the object). You couldn’t interchange Entities because there would be unwanted side effects.

    Secondly, overtime an Entity’s properties will change, but it will remain the same Entity. For example, if a user changes their email address. However when your application needs to change a Value Object property, the whole object needs to be destroyed and a new one should replace it. For example, when you make a payment, the money object isn’t given back to you as change, you are given a new money object of a lower value.

  - Conclusion

    The difference between Entities and Value objects is an important concept in Domain Driven Design. In DDD, it’s important to identify the difference between Entities and Value Objects in order to model the real world correctly in our application.

    As I mentioned in this post, it’s important to fully understand the context of what you are building so that you know when an object should be an Entity and when it should be a Value Object. Just because at first glance and object would seem to have an identity, does not mean that it should be an Entity. Modelling a concept as an Entity with an identity, when it should be an immutable Value Object can have unwanted side effects.

    Immutable Value Objects are an important part of building an application that correctly represents the intended design. Using Value Objects for things such as money for example, also ensures that mistakes aren’t made due to an object’s changing state through time.

    Understanding the difference between Entities and Value Objects isn’t always apparent, and will require that you fully get your head around the context of the application you are building. However, the distinction is important, and is something that you should be aware of as you model a real world system as a new application in code.

## 9. Exceptions

- About

  Any time your code encounters an unexpected condition that it can't handle, an exception should be thrown. In this lesson, we'll review the "why, how, and when" of exceptions, as well as some interesting ways to improve readability through naming and static constructors.

- Exceptions ¶

  - PHP has an exception model similar to that of other programming languages. An exception can be `throw`n, and caught ("`catch`ed") within PHP. Code may be surrounded in a `try` block, to facilitate the catching of potential exceptions. Each `try` must have at least one corresponding `catch` or `finally` block.

  - If an exception is thrown and its current function scope has no `catch` block, the exception will "bubble up" the call stack to the calling function until it finds a matching `catch` block. All `finally` blocks it encounters along the way will be executed. If the call stack is unwound all the way to the global scope without encountering a matching `catch` block, the program will terminate with a fatal error unless a global exception handler has been set.

  - The thrown object must be an `instanceof` `Throwable`. Trying to throw an object that is not will result in a PHP Fatal Error.

  - As of PHP 8.0.0, the `throw` keyword is an expression and may be used in any expression context. In prior versions it was a statement and was required to be on its own line.

  - catch ¶

    - A `catch` block defines how to respond to a thrown exception. A `catch` block defines one or more types of exception or error it can handle, and optionally a variable to which to assign the exception. (The variable was required prior to PHP 8.0.0.) The first `catch` block a thrown exception or error encounters that matches the type of the thrown object will handle the object.

    - Multiple `catch` blocks can be used to `catch` different classes of exceptions. Normal execution (when no exception is thrown within the try block) will continue after that last `catch` block defined in sequence. Exceptions can be thrown (or re-`throw`n) within a `catch` block. If not, execution will continue after the `catch` block that was triggered.

    - When an exception is thrown, code following the statement will not be executed, and PHP will attempt to find the first matching `catch` block. If an exception is not caught, a PHP Fatal Error will be issued with an "Uncaught Exception ..." message, unless a handler has been defined with `set_exception_handler()`.

    - As of PHP 7.1.0, a `catch` block may specify multiple exceptions using the pipe (|) character. This is useful for when different exceptions from different class hierarchies are handled the same.

    - As of PHP 8.0.0, the variable name for a caught exception is optional. If not specified, the `catch` block will still execute but will not have access to the thrown object.

  - finally ¶

    - A `finally` block may also be specified after or instead of `catch` blocks. Code within the `finally` block will always be executed after the `try` and `catch` blocks, regardless of whether an exception has been thrown, and before normal execution resumes.

    - One notable interaction is between the `finally` block and a `return` statement. If a `return` statement is encountered inside either the `try` or the `catch` blocks, the `finally` block will still be executed. Moreover, the `return` statement is evaluated when encountered, but the result will be returned after the `finally` block is executed. Additionally, if the `finally` block also contains a `return` statement, the value from the `finally` block is returned.

  - Global exception handler ¶

    - If an exception is allowed to bubble up to the global scope, it may be caught by a global exception handler if set. The `set_exception_handler()` function can set a function that will be called in place of a `catch` block if no other block is invoked. The effect is essentially the same as if the entire program were wrapped in a `try-catch` block with that function as the `catch`.

  - Notes ¶

    - Note:

      - Internal PHP functions mainly use `Error reporting`, only modern `Object-oriented` extensions use exceptions. However, errors can be easily translated to exceptions with `ErrorException`. This technique only works with non-fatal errors, however.

      - **Example #1 Converting error reporting to exceptions**

        ```php
        <?php
        function exceptions_error_handler($severity, $message, $filename, $lineno) {
            throw new ErrorException($message, 0, $severity, $filename, $lineno);
        }

        set_error_handler('exceptions_error_handler');
        ?>
        ```

    - Tip
      - The` Standard PHP Library (SPL)` provides a good number of `built-in exceptions`.

  - Examples ¶

    - **Example #2 Throwing an Exception**

      ```php
      <?php
      function inverse($x) {
          if (!$x) {
              throw new Exception('Division by zero.');
          }
          return 1/$x;
      }

      try {
          echo inverse(5) . "\n";
          echo inverse(0) . "\n";
      } catch (Exception $e) {
          echo 'Caught exception: ',  $e->getMessage(), "\n";
      }

      // Continue execution
      echo "Hello World\n";
      ?>
      ```

      - The above example will output:

        ```bash
        0.2
        Caught exception: Division by zero.
        Hello World
        ```

    - **Example #3 Exception handling with a finally block**

      ```php
      <?php
      function inverse($x) {
          if (!$x) {
              throw new Exception('Division by zero.');
          }
          return 1/$x;
      }

      try {
          echo inverse(5) . "\n";
      } catch (Exception $e) {
          echo 'Caught exception: ',  $e->getMessage(), "\n";
      } finally {
          echo "First finally.\n";
      }

      try {
          echo inverse(0) . "\n";
      } catch (Exception $e) {
          echo 'Caught exception: ',  $e->getMessage(), "\n";
      } finally {
          echo "Second finally.\n";
      }

      // Continue execution
      echo "Hello World\n";
      ?>
      ```

      - The above example will output:

        ```bash
        0.2
        First finally.
        Caught exception: Division by zero.
        Second finally.
        Hello World
        ```

    - **Example #4 Interaction between the finally block and return**

      ```php
      <?php

      function test() {
          try {
              throw new Exception('foo');
          } catch (Exception $e) {
              return 'catch';
          } finally {
              return 'finally';
          }
      }

      echo test();
      ?>
      ```

      - The above example will output:

        ```
        finally
        ```

    - **Example #5 Nested Exception**

      ```php
      <?php

      class MyException extends Exception { }

      class Test {
          public function testing() {
              try {
                  try {
                      throw new MyException('foo!');
                  } catch (MyException $e) {
                      // rethrow it
                      throw $e;
                  }
              } catch (Exception $e) {
                  var_dump($e->getMessage());
              }
          }
      }

      $foo = new Test;
      $foo->testing();

      ?>
      ```

      - The above example will output:

        ```
        string(4) "foo!"
        ```

    - **Example #6 Multi catch exception handling**

      ```php
      <?php

      class MyException extends Exception { }

      class MyOtherException extends Exception { }

      class Test {
          public function testing() {
              try {
                  throw new MyException();
              } catch (MyException | MyOtherException $e) {
                  var_dump(get_class($e));
              }
          }
      }

      $foo = new Test;
      $foo->testing();

      ?>
      ```

      - The above example will output:

        ```
        string(11) "MyException"
        ```

    - **Example #7 Omitting the caught variable**

      - Only permitted in PHP 8.0.0 and later.

      ```php
      <?php

      class SpecificException extends Exception {}

      function test() {
          throw new SpecificException('Oopsie');
      }

      try {
          test();
      } catch (SpecificException) {
          print "A SpecificException was thrown, but we don't care about the details.";
      }
      ?>
      ```

    - **Example #8 Throw as an expression**

      - Only permitted in PHP 8.0.0 and later.

      ```php
      <?php

      function test() {
          do_something_risky() or throw new Exception('It did not work');
      }

      try {
          test();
      } catch (Exception $e) {
          print $e->getMessage();
      }
      ?>
      ```

  - User Contributed Notes

    1. If you intend on creating a lot of custom exceptions, you may find this code useful. I've created an interface and an abstract exception class that ensures that all parts of the built-in Exception class are preserved in child classes. It also properly pushes all information back to the parent constructor ensuring that nothing is lost. This allows you to quickly create new exceptions on the fly. It also overrides the default \_\_toString method with a more thorough one.

    ```php
    <?php
    interface IException
    {
        /* Protected methods inherited from Exception class */
        public function getMessage();                 // Exception message
        public function getCode();                    // User-defined Exception code
        public function getFile();                    // Source filename
        public function getLine();                    // Source line
        public function getTrace();                   // An array of the backtrace()
        public function getTraceAsString();           // Formated string of trace

        /* Overrideable methods inherited from Exception class */
        public function __toString();                 // formated string for display
        public function __construct($message = null, $code = 0);
    }

    abstract class CustomException extends Exception implements IException
    {
        protected $message = 'Unknown exception';     // Exception message
        private   $string;                            // Unknown
        protected $code    = 0;                       // User-defined exception code
        protected $file;                              // Source filename of exception
        protected $line;                              // Source line of exception
        private   $trace;                             // Unknown

        public function __construct($message = null, $code = 0)
        {
            if (!$message) {
                throw new $this('Unknown '. get_class($this));
            }
            parent::__construct($message, $code);
        }

        public function __toString()
        {
            return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
                                    . "{$this->getTraceAsString()}";
        }
    }
    ?>
    ```

    - Now you can create new exceptions in one line:

      ```php
      <?php
      class TestException extends CustomException {}
      ?>
      ```

    - Here's a test that shows that all information is properly preserved throughout the backtrace.

      ```php
      <?php
      function exceptionTest()
      {
          try {
              throw new TestException();
          }
          catch (TestException $e) {
              echo "Caught TestException ('{$e->getMessage()}')\n{$e}\n";
          }
          catch (Exception $e) {
              echo "Caught Exception ('{$e->getMessage()}')\n{$e}\n";
          }
      }

      echo '<pre>' . exceptionTest() . '</pre>';
      ?>
      ```

      - Here's a sample output:

        ```
        Caught TestException ('Unknown TestException')
        TestException 'Unknown TestException' in C:\xampp\htdocs\CustomException\CustomException.php(31)
        #0 C:\xampp\htdocs\CustomException\ExceptionTest.php(19): CustomException->__construct()
        #1 C:\xampp\htdocs\CustomException\ExceptionTest.php(43): exceptionTest()
        #2 {main}
        ```
