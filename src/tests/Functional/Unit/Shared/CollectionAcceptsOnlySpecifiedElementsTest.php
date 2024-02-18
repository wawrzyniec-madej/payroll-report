<?php

declare(strict_types=1);

namespace App\Tests\Functional\Unit\Shared;

use App\Shared\InvalidCollectionElementException;
use App\Tests\Helper\ClassA;
use App\Tests\Helper\ClassACollection;
use App\Tests\Helper\ClassB;
use PHPUnit\Framework\TestCase;

final class CollectionAcceptsOnlySpecifiedElementsTest extends TestCase
{
    public function testThrowsExceptionOnImproperElement(): void
    {
        $this->expectException(InvalidCollectionElementException::class);

        $collection = ClassACollection::createEmpty();

        $collection->add(
            new ClassB()
        );
    }

    public function testAcceptsProperElements(): void
    {
        $collection = ClassACollection::createEmpty();

        $collection->add(
            new ClassA()
        );

        self::assertCount(1, $collection);
    }
}
