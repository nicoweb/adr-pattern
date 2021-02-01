<?php

declare(strict_types=1);

namespace App\Responder;

use App\Http\RedirectResponse;
use App\Http\Response;

interface Responder
{
    public function render(string $name, array $context = []): Response;
    public function redirectToRoute(string $route, array $parameters = [], int $status = 302): RedirectResponse;
}
