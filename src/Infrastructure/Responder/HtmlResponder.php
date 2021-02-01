<?php

declare(strict_types=1);

namespace App\Infrastructure\Responder;

use App\Http\RedirectResponse;
use App\Http\Response;
use App\Infrastructure\Http\HtmlResponse;
use App\Infrastructure\Http\SfRedirectResponse;
use App\Responder\Responder;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Environment;

class HtmlResponder implements Responder
{
    public function __construct(
        private Environment $twig,
        private UrlGeneratorInterface $urlGenerator,
    ) {}

    public function render(string $name, array $context = []): Response
    {
        return new HtmlResponse($this->twig->render($name, $context));
    }

    public function redirectToRoute(string $route, array $parameters = [], int $status = 302): RedirectResponse
    {
        return new SfRedirectResponse($this->urlGenerator->generate($route, $parameters),
            $status
        );
    }
}
