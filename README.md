Equation
===========

基于 bc_math 的 PHP 公式解析器

Install
---------------
```shell
$ composer install lang\equation
```

Simple examples
---------------

```PHP
<?php

use Lang\Equation\Equation;

$expr = Equation::parse('1+1');
echo $expr->getValue();
// Output: 2

// With params
// !notice parameter name format: ':param_name:'
$expr2 = Equation::parse('2 + :var:');
echo $expr2->getValue(['var' => 2]);
// Output: 4
```

License
-------

MIT license (© 2024 Lang)

Have fun with **Equation**
