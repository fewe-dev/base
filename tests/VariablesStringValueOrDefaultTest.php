<?php

declare(strict_types=1);

use FeWeDev\Base\Variables;
use PHPUnit\Framework\TestCase;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class VariablesStringValueOrDefaultTest extends TestCase
{
    public function testString(): void
    {
        $variables = new Variables();

        $this->assertSame('text', $variables->stringValueOrDefault('text'));
    }

    public function testScalars(): void
    {
        $variables = new Variables();

        $this->assertSame('42', $variables->stringValueOrDefault(42));
        $this->assertSame('1.5', $variables->stringValueOrDefault(1.5));
        $this->assertSame('1', $variables->stringValueOrDefault(true));
        $this->assertSame('', $variables->stringValueOrDefault(false));
    }

    public function testObjectWithToString(): void
    {
        $variables = new Variables();

        $value = new class {
            public function __toString(): string
            {
                return 'object text';
            }
        };

        $this->assertSame('object text', $variables->stringValueOrDefault($value));
    }

    public function testNull(): void
    {
        $variables = new Variables();

        $this->assertSame('', $variables->stringValueOrDefault(null));
        $this->assertSame('none', $variables->stringValueOrDefault(null, 'none'));
    }

    public function testArray(): void
    {
        $variables = new Variables();

        $this->assertSame('', $variables->stringValueOrDefault(['value']));
        $this->assertSame('none', $variables->stringValueOrDefault(['value'], 'none'));
    }

    public function testObjectWithoutToString(): void
    {
        $variables = new Variables();

        $this->assertSame('none', $variables->stringValueOrDefault(new stdClass(), 'none'));
    }

    public function testStringValueKeepsItsResult(): void
    {
        $variables = new Variables();

        $this->assertSame('NULL', $variables->stringValue(null));
    }
}
