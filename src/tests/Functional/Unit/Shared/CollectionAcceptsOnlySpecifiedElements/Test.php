<?php

namespace App\Tests\Functional\Unit\Shared\CollectionAcceptsOnlySpecifiedElements;

use App\Shared\Domain\Exception\CollectionElementInvalidException;
use App\Tests\Functional\Unit\Shared\CollectionAcceptsOnlySpecifiedElements\Helper\ClassA;
use App\Tests\Functional\Unit\Shared\CollectionAcceptsOnlySpecifiedElements\Helper\ClassACollection;
use App\Tests\Functional\Unit\Shared\CollectionAcceptsOnlySpecifiedElements\Helper\ClassB;
use PHPUnit\Framework\TestCase;

final class Test extends TestCase
{
    public function testThrowsExceptionOnImproperElement(): void
    {
        $this->expectException(CollectionElementInvalidException::class);

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
