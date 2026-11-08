<?php

declare(strict_types=1);

use FeWeDev\Base\Variables;
use PHPUnit\Framework\TestCase;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class VariablesIntValueTest extends TestCase
{
    public function testInteger(): void
    {
        $variables = new Variables();

        $result = $variables->intValue(42);

        $this->assertSame(42, $result);
    }

    public function testDigitString(): void
    {
        $variables = new Variables();

        $result = $variables->intValue('42');

        $this->assertSame(42, $result);
    }

    public function testNegativeString(): void
    {
        $variables = new Variables();

        $result = $variables->intValue('-7');

        $this->assertSame(-7, $result);
    }

    public function testFloat(): void
    {
        $variables = new Variables();

        $result = $variables->intValue(3.9);

        $this->assertSame(3, $result);
    }

    public function testBoolean(): void
    {
        $variables = new Variables();

        $result = $variables->intValue(true);

        $this->assertSame(1, $result);
    }

    public function testNullIsInvalid(): void
    {
        $variables = new Variables();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Could not convert value: NULL to int');

        $variables->intValue(null);
    }

    public function testArrayIsInvalid(): void
    {
        $variables = new Variables();

        $this->expectException(InvalidArgumentException::class);

        $variables->intValue([1]);
    }

    public function testInvalidValueIsStillAnException(): void
    {
        $variables = new Variables();

        // callers that catch \Exception keep working
        $this->expectException(Exception::class);

        $variables->intValue(new stdClass());
    }
}
