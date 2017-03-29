# Util

[![Build Status](https://travis-ci.org/SolidWorx/Util.svg)](https://travis-ci.org/SolidWorx/Util)

A collection of utility classes for everyday use

# Table of Contents
- [Requirements](#requirements)
- [Installation](#installation)
    - [Composer](#composer)
- [Usage](#usage)
    - [ArrayUtil](#arrayUtil)
- [Testing](#testing)
- [Contributing](#contributing)
- [Licence](#licence)

## Requirements

Minimum PHP requirement is PHP 7.1+

## Installation

### Composer

```bash
$ composer require solidworx/util
```

## Usage

### ArrayUtil

<b>column</b>:

Return the values from a single column in the input array. The input can be an array of arrays or objects.
This method is an enhancement to the normal `array_column` function.
This can be useful if you need to get a specific value from a collection.

Using an array input

```php
<?php
$input = [
    ['test' => 'one'],
    ['test' => 'two'],
    ['test' => 'three'],
];

$columns = ArrayUtil::column($input, 'test');

/* $columns = array (
                  0 => 'one',
                  1 => 'two',
                  2 => 'three',
              );*/

```

Using an object with public properties

```php
<?php

class Foo {
    public $test;
}

$foo1 = new Foo;
$foo1->test = 'one';

$foo2 = new Foo;
$foo2->test = 'two';

$foo3 = new Foo;
$foo3->test = 'three';

$input = [
    $foo1,
    $foo2,
    $foo3,
];

$columns = ArrayUtil::column($input, 'test');

/* $columns = array (
                  0 => 'one',
                  1 => 'two',
                  2 => 'three',
              );*/

```

Using an object with methods

```php
<?php

class Foo {
    private $value;
    
    public function __construct($value)
    {
        $this->value = $value;
    }
    
    public function test()
    {
        return $this->>value;
    }
}

$input = [
    new Foo('one'),
    new Foo('two'),
    new Foo('three'),
];

$columns = ArrayUtil::column($input, 'test');

/* $columns = array (
                  0 => 'one',
                  1 => 'two',
                  2 => 'three',
              );*/

```

Using an object with getters

```php
<?php

class Foo {
    private $value;
    
    public function __construct($value)
    {
        $this->value = $value;
    }
    
    public function getTest()
    {
        return $this->value;
    }
}

$input = [
    new Foo('one'),
    new Foo('two'),
    new Foo('three'),
];

$columns = ArrayUtil::column($input, 'test');

/* $columns = array (
                  0 => 'one',
                  1 => 'two',
                  2 => 'three',
              );*/

```


Getting all the email addresses of your users:

```php
<?php

$users = $userRepository->findAll();

$emails = ArrayUtil::column($users, 'email');

```

By default, all the `null` values are filtered out. If you want to keep the `null` values, pass `false` as the third parameter:

```php
$users = $userRepository->findAll();

$emails = ArrayUtil::column($users, 'email', false); // Will keep empty values in the result 
```


## Testing

To run the unit tests, execute the following command

```bash
$ vendor/bin/phpunit
```

## Contributing

See [CONTRIBUTING](https://github.com/SolidWorx/Util/blob/master/CONTRIBUTING.md)

## License

This library is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Please see the [LICENSE](LICENSE) file for the full license.
