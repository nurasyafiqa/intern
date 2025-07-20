# Useful TestSuite additions

Let's you test even faster.

## TestTrait

This trait adds the following methods to your test suite:

### invokeMethod()

If you need to check a protected or private method directly:
```php
$object = new Object();
$arguments = ['first', 'second'];
$this->invokeMethod($object, 'mySecretMethod', $arguments);
```

### invokeProperty()

If you need to make a protected or private property visible or accessible in your test:
```php
$object = new Object();
$this->invokeProperty($object, '_foo');
```

### osFix()

In case you need to format certain os specific files to "\n" before comparing
them as strings.

### isVerbose()

```
phpunit -v
phpunit -vv
```
This can be useful to conditionally output more debug information.

### isDebug()
With this method you can apply additional testing code if a `--debug` flag has been set.

```
phpunit --debug
```
As an example you can by default mock out some API call, but with the debug flat set use
the real API connection (for local testing). This way you can quickly confirm that the API
connection is not only still working in simulated (mocking) the way it used to, but also
that it's still the real deal.
```php
$this->Api = new ApiClass();

if (!$this->isDebug()) {
    $this->Api = $this->getMock('ApiClass');
    $this->Api->expects(...)->...;
}
```

### debug()

This is very useful when debugging certain tests when writing them.

```php
$result = $this->get($id);
$this->debug($result);

$this->assertSomething(...);
```
Here the debug statement is harmless by default. Only when you run phpunit with `-v` or `-vv`,
additional debug output is printed to the screen.

By default this trait is attached to IntegrationTestCase, TestCase and ConsoleOutput.

Tip: This verbose debug feature is best used in combination with `--filter testMethodToTest`, as
otherwise there might be too much output on the screen. So better filter down to the actual method
you are currently working on or debugging:
```
php phpunit.phar --filter testFooBar /path/to/SomeTest.php -vv
```

## IntegrationTestCase

See the above trait features.

### Disable ErrorHandlerMiddleware
You can globally set
```php
    protected $disableErrorHandlerMiddleware = true;
```

This is a quick way to disable all error handler middlewares on this integration test case.
A useful default for all controllers/actions that are not expected to provide an error result (2xx/3xx).

## TestCase

Also see the above trait features.

## ConsoleOutput
By default, this class captures the output to stderr or stdout internally in an array.

```php
namespace App\Test\TestCase\Shell;

use App\Shell\FooBarShell;
use Cake\Console\ConsoleIo;
use Shim\TestSuite\ConsoleOutput;
use Shim\TestSuite\TestCase;

class FooBarShellTest extends TestCase {

    /**
     * @return void
     */
    public function setUp(): void {
        parent::setUp();

        $this->out = new ConsoleOutput();
        $this->err = new ConsoleOutput();
        $io = new ConsoleIo($this->out, $this->err);

        $this->Shell = $this->getMock(
            'App\Shell\FooBarShell',
            ['in', '_stop'],
            [$io]
        );
    }
```
Note that we mock the `in` and `_stop` methods, though, to allow handling those by mocking them out in the test cases.

You can afterwards check on the output:
```php
$this->Shell->runCommand(['baz']);

$output = $this->err->output();
$this->assertEmpty($output);

$output = $this->out->output();
$expected = 'FooBars';
$this->assertStringContainsString($expected, $output);
```

Also see the above trait features. By using `-v` or `-vv` you can directly see any stderr or stdout output on the screen.
Otherwise they will not be displayed automatically.
passwordToCrypt'));
```

### invokeProperty()

If you need to make a protected or private property visible or accessible in your test:
```php
$object = new Object();
$this->invokeProperty($object, '_foo');
```

### osFix()

In case you need to format certain os specific files to "\n" before comparing
them as strings.

### isVerbose()

```
phpunit -v
phpunit -vv
```
This can be useful to conditionally output more debug information.

### isDebug()
With this method you can apply additional testing code if a `--debug` flag has been set.

```
phpunit --debug
```
As an example you can by default mock out some API call, but with the debug flat set use
the real API connection (for local testing). This way you can quickly confirm that the API
connection is not only still working in simulated (mocking) the way it used to, but also
that it's still the real deal.
```php
$this->Api = new ApiClass();

if (!$this->isDebug()) {
    $this->Api = $this->getMock('ApiClass');
    $this->Api->expects(...)->...;
}
```

### debug()

This is very useful when debugging certain tests when writing them.

```php
$result = $this->get($id);
$this->debug($result);

$this->assertSomething(...);
```
Here the debug statement is harmless by default. Only when you run phpunit with `-v` or `-vv`,
additional debug output is printed to the screen.

By default this trait is attached to IntegrationTestCase, TestCase and ConsoleOutput.

Tip: This verbose debug feature is best used in combination with `--filter testMethodToTest`, as
otherwise there might be too much output on the screen. So better filter down to the actual method
you are currently working on or debugging:
```
php phpunit.phar --filter testFooBar /path/to/SomeTest.php -vv
```

## IntegrationTestCase

See the above trait features.

### Disable ErrorHandlerMiddleware
You can globally set
```php
    protected $disableErrorHandlerMiddleware = true;
```

This is a quick way to disable all error handler middlewares on this integration test case.
A useful default for all controllers/actions that are not expected to provide an error result (2xx/3xx).

## TestCase

Also see the above trait features.

## ConsoleOutput
By default, this class captures the output to stderr or stdout internally in an array.

```php
namespace App\Test\TestCase\Shell;

use App\Shell\FooBarShell;
use Cake\Console\ConsoleIo;
use Shim\TestSuite\ConsoleOutput;
use Shim\TestSuite\TestCase;

class FooBarShellTest extends TestCase {

    /**
     * @return void
     */
    public function setUp(): void {
        parent::setUp();

        $this->out = new ConsoleOutput();
        $this->err = new ConsoleOutput();
        $io = new ConsoleIo($this->out, $this->err);

        $this->Shell = $this->getMock(
            'App\Shell\FooBarShell',
            ['in', '_stop'],
            [$io]
        );
    }
```
Note that we mock the `in` and `_stop` methods, though, to allow handling those by mocking them out in the test cases.

You can afterwards check on the output:
```php
$this->Shell->runCommand(['baz']);

$output = $this->err->output();
$this->assertEmpty($output);

$output = $this->out->output();
$expected = 'FooBars';
$this->assertStringContainsString($expected, $output);
```

Also see the above trait features. By using `-v` or `-vv` you can directly see any stderr or stdout output on the screen.
Otherwise they will not be displayed automatically.
