<?php

declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Http\RedirectResponse;

class SfRedirectResponse extends \Symfony\Component\HttpFoundation\RedirectResponse implements RedirectResponse
{
}
