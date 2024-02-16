<?php

namespace App\Shared\Domain;

use App\Shared\Domain\Exception\CollectionElementInvalidException;
use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @template T of object
 */
abstract class TypedCollection implements IteratorAggregate
{
    /** @param list<object> $elements */
    private final function __construct(
        private readonly array $elements = []
    ) {
        foreach ($this->elements as $element) {
            $this->validate($element);
        }
    }

    public static function createEmpty(): static
    {
        return new static();
    }

    /** @param array<string|int, object> $elements */
    public static function createFromArray(array $elements): static
    {
        return new static(array_values($elements));
    }

    public static function fromSpread(object ...$elements): static
    {
        return static::createFromArray($elements);
    }

    public function add(object $element): static
    {
        return new static([
            ...$this->elements,
            $element
        ]);
    }

    private function validate(object $element): void
    {
        $allowedType = $this->typeAllowed();

        if (!$element instanceof $allowedType) {
            throw CollectionElementInvalidException::create($element::class, $allowedType);
        }
    }

    /** @return ArrayIterator<int, object> */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }

    /** @return class-string */
    abstract public function typeAllowed(): string;
}