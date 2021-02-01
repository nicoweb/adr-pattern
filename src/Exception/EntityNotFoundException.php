<?php

declare(strict_types=1);

namespace App\Exception;

use Exception;

final class EntityNotFoundException extends Exception
{
    public function __construct(?string $id, string $className)
    {
        parent::__construct(sprintf('Id "%s" of Entity "%s"  was not found', $id, $className));
    }
}
