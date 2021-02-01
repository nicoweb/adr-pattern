<?php

declare(strict_types=1);

namespace App\Paginator;

interface Pagination
{
    public function getRoute(): ?string;

    public function getParams(): array;

    /**
     * @param string[]|string|null $key
     */
    public function isSorted($key = null, array $params = []): bool;

    public function getPaginationData(): array;

    public function getPaginatorOptions(): ?array;

    public function getCustomParameters(): ?array;
}
