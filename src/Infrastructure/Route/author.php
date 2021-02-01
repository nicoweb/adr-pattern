<?php

declare(strict_types=1);

use App\Action\Author\AuthorCreateAction;
use App\Action\Author\AuthorDeleteAction;
use App\Action\Author\AuthorEditAction;
use App\Action\Author\AuthorListAction;
use App\Action\Author\AuthorShowAction;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('index', '/')
        ->controller(AuthorListAction::class)
        ->methods(['GET'])
    ;

    $routes->add('new', '/new')
        ->controller(AuthorCreateAction::class)
        ->methods(['GET', 'POST'])
    ;

    $routes->add('show', '/{id}')
        ->controller(AuthorShowAction::class)
        ->methods(['GET'])
    ;

    $routes->add('edit', '/{id}/edit')
        ->controller(AuthorEditAction::class)
        ->methods(['GET', 'POST'])
    ;

    $routes->add('delete', '/{id}')
        ->controller(AuthorDeleteAction::class)
        ->methods(['DELETE'])
    ;
};
