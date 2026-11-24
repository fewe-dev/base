<?php

declare(strict_types=1);

use FeWeDev\Base\Variables;
use PHPUnit\Framework\TestCase;

/**
 * @author      Andreas Knollmann
 * @copyright   2014-2026 Softwareentwicklung Andreas Knollmann
 * @license     http://www.opensource.org/licenses/mit-license.php MIT
 */
class VariablesGetChangedDataTest extends TestCase
{
    public function testUnchangedData(): void
    {
        $variables = new Variables();

        $result = $variables->getChangedData(
            ['name' => 'Bag', 'price' => '10.00', 'status' => true, 'qty' => 5],
            ['name' => 'bag', 'price' => 10, 'status' => 1, 'qty' => '5.0000']
        );

        $this->assertSame([], $result);
    }

    public function testChangedValues(): void
    {
        $variables = new Variables();

        $result = $variables->getChangedData(
            ['name' => 'Bag', 'price' => '10.00', 'qty' => 5],
            ['name' => 'Tote', 'price' => '12.00', 'qty' => 5]
        );

        $this->assertSame(['name', 'price'], $result);
    }

    public function testChangedBooleanReturnsTheKey(): void
    {
        $variables = new Variables();

        $result = $variables->getChangedData(
            ['enabled' => true, 'visible' => false, 'salable' => true],
            ['enabled' => false, 'visible' => '1', 'salable' => '0']
        );

        $this->assertSame(['enabled', 'visible', 'salable'], $result);
    }

    public function testKeysOfOnlyOneSide(): void
    {
        $variables = new Variables();

        $result = $variables->getChangedData(
            ['name' => 'Bag', 'color' => 'red', 'material' => null],
            ['name' => 'Bag', 'size' => 'L', 'news_from_date' => null, 'gift_message' => '']
        );

        $this->assertSame(['color', 'size'], $result);
    }

    public function testEmptyOldData(): void
    {
        $variables = new Variables();

        $result = $variables->getChangedData([], ['name' => 'Bag', 'updated_at' => '2026-11-24 10:00:00']);

        $this->assertSame(['name'], $result);
    }

    public function testEmptyNewData(): void
    {
        $variables = new Variables();

        $result = $variables->getChangedData(['name' => 'Bag', 'updated_at' => '2026-11-24 10:00:00'], []);

        $this->assertSame(['name'], $result);
    }

    public function testNull(): void
    {
        $variables = new Variables();

        $result = $variables->getChangedData(
            ['description' => null, 'meta_title' => null, 'meta_keyword' => 'bag'],
            ['description' => 'A bag', 'meta_title' => '', 'meta_keyword' => null]
        );

        $this->assertSame(['description', 'meta_keyword'], $result);
    }

    public function testUpdatedAtAndArraysAreIgnored(): void
    {
        $variables = new Variables();

        $result = $variables->getChangedData(
            ['updated_at' => '2026-11-23 10:00:00', 'media_gallery' => ['images' => []]],
            ['updated_at' => '2026-11-24 10:00:00', 'media_gallery' => ['images' => [1]]]
        );

        $this->assertSame([], $result);
    }
}
