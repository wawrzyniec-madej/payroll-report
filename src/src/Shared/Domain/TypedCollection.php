<?php

namespace App\Shared\Domain;

use App\Shared\Domain\Exception\CollectionElementInvalidException;

/**
 * This class could be immutable in nature, so add method will return new instance containing new element.
 *
 * @template T of object
 */
abstract class TypedCollection implements \IteratorAggregate
{
    /** @param list<T> $elements */
    final private function __construct(
        protected array $elements
    ) {
        foreach ($this->elements as $element) {
            $this->validate($element);
        }
    }

    /** @param list<T> $elements */
    public static function createFromArray(array $elements): static
    {
        return new static($elements);
    }

    public static function createEmpty(): static
    {
        return new static([]);
    }

    public function add(object $element): static
    {
        /** @var T $validatedElement */
        $validatedElement = $this->validate($element);

        $this->elements[] = $validatedElement;

        return $this;
    }

    /** @return list<mixed> */
    public function map(callable $function): array
    {
        return array_map(
            $function,
            $this->elements
        );
    }

    private function validate(object $element): object
    {
        $allowedType = $this->typeAllowed();

        if (!$element instanceof $allowedType) {
            throw CollectionElementInvalidException::create($element::class, $allowedType);
        }

        return $element;
    }

    /** @return \ArrayIterator<int, T> */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->elements);
    }

    /** @return class-string */
    abstract public function typeAllowed(): string;
}
