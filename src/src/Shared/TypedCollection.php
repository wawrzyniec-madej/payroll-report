<?php

declare(strict_types=1);

namespace App\Shared;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * This class could be immutable in nature, so add method will return new instance containing new element.
 *
 * @template T of object
 */
abstract class TypedCollection implements IteratorAggregate
{
    /**
     * @param list<T> $elements
     */
    final private function __construct(
        protected array $elements
    ) {
        foreach ($this->elements as $element) {
            $this->validate($element);
        }
    }

    public static function createEmpty(): static
    {
        return new static([]);
    }

    public static function createFromSpread(object ...$elements): static
    {
        /** @var list<T> $listedElements */
        $listedElements = $elements;

        return new static($listedElements);
    }

    public function add(object $element): static
    {
        /** @var T $validatedElement */
        $validatedElement = $this->validate($element);

        $this->elements[] = $validatedElement;

        return $this;
    }

    private function validate(object $element): object
    {
        $allowedType = $this->typeAllowed();

        if (!$element instanceof $allowedType) {
            throw InvalidCollectionElementException::create($element::class, $allowedType);
        }

        return $element;
    }

    /** @return ArrayIterator<int, T> */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }

    /** @return class-string */
    abstract public function typeAllowed(): string;
}
