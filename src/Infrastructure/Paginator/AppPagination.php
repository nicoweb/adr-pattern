<?php

declare(strict_types=1);

namespace App\Infrastructure\Paginator;

use App\Paginator\Pagination;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;

final class AppPagination implements Pagination, SlidingPaginationInterface, \Iterator
{
    private SlidingPaginationInterface $pagination;

    public function __construct(SlidingPaginationInterface $pagination)
    {
        $this->pagination = $pagination;
    }

    public function getRoute(): ?string
    {
        return $this->pagination->getRoute();
    }

    public function getParams(): array
    {
        return $this->pagination->getParams();
    }

    public function isSorted($key = null, array $params = []): bool
    {
        return $this->pagination->isSorted($key, $params);
    }

    public function getPaginationData(): array
    {
        return $this->pagination->getPaginationData();
    }

    public function getPaginatorOptions(): ?array
    {
        return $this->pagination->getPaginatorOptions();
    }

    public function getCustomParameters(): ?array
    {
        return $this->pagination->getCustomParameters();
    }

    public function setCurrentPageNumber(int $pageNumber): void
    {
        $this->pagination->setCurrentPageNumber($pageNumber);
    }

    public function getCurrentPageNumber(): int
    {
        return $this->pagination->getCurrentPageNumber();
    }

    public function setItemNumberPerPage(int $numItemsPerPage): void
    {
        $this->pagination->setItemNumberPerPage($numItemsPerPage);
    }

    public function getItemNumberPerPage(): int
    {
        return $this->pagination->getItemNumberPerPage();
    }

    public function setTotalItemCount(int $numTotal): void
    {
        $this->pagination->setTotalItemCount($numTotal);
    }

    public function getTotalItemCount(): int
    {
        return $this->pagination->getTotalItemCount();
    }

    public function setItems(iterable $items): void
    {
        $this->pagination->setItems($items);
    }

    public function getItems(): iterable
    {
        return $this->pagination->getItems();
    }

    public function setPaginatorOptions(array $options): void
    {
        $this->pagination->setPaginatorOptions($options);
    }

    public function getPaginatorOption(string $name)
    {
        return $this->pagination->getPaginatorOption($name);
    }

    public function setCustomParameters(array $parameters): void
    {
        $this->pagination->setCustomParameters($parameters);
    }

    public function getCustomParameter(string $name)
    {
        return $this->pagination->getCustomParameter($name);
    }

    public function offsetExists($offset): bool
    {
        return $this->pagination->offsetExists($offset);
    }

    public function offsetGet($offset)
    {
        return $this->pagination->offsetGet($offset);
    }

    public function offsetSet($offset, $value): void
    {
        $this->pagination->offsetSet($offset, $value);
    }

    public function offsetUnset($offset): void
    {
        $this->pagination->offsetUnset($offset);
    }

    public function count(): int
    {
        $this->pagination->count();
    }

    public function getTemplate(): ?string
    {
        return $this->pagination->getTemplate();
    }

    public function current()
    {
        return $this->pagination->current();
    }

    public function next()
    {
        $this->pagination->next();
    }

    public function key()
    {
        return $this->pagination->key();
    }

    public function valid()
    {
        return $this->pagination->valid();
    }

    public function rewind()
    {
        return $this->pagination->rewind();
    }
}
