<?php

namespace App\ViewModel\Book\Object;

class BookRecursive
{
    public function __construct(
        private int    $id,
        private string $name,
        private array  $child,
        private array  $books,
    )
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getChild(): array
    {
        return $this->child;
    }

    /**
     * @return array
     */
    public function getBooks(): array
    {
        return $this->books;
    }
}
