<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\ArgumentResolver;

use Generator;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\HttpMessageFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class Psr7ServerRequestResolver implements ArgumentValueResolverInterface
{
    private const SUPPORTED_TYPES = [
        ServerRequestInterface::class => true,
        RequestInterface::class => true,
    ];

    private HttpMessageFactoryInterface $httpMessageFactory;

    public function __construct(HttpMessageFactoryInterface $httpMessageFactory)
    {
        $this->httpMessageFactory = $httpMessageFactory;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return isset(self::SUPPORTED_TYPES[$argument->getType()]);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): Generator
    {
        yield $this->httpMessageFactory->createRequest($request);
    }
}
