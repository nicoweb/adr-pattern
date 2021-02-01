<?php

declare(strict_types=1);

use App\Action\BlogPost\BlogPostCreateAction;
use App\Action\BlogPost\BlogPostDeleteAction;
use App\Action\BlogPost\BlogPostEditAction;
use App\Action\BlogPost\BlogPostListAction;
use App\Action\BlogPost\BlogPostShowAction;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->add('post_index', '/')
        ->controller(BlogPostListAction::class)
        ->methods(['GET'])
    ;

    $routes->add('post_new', '/new')
        ->controller(BlogPostCreateAction::class)
        ->methods(['GET', 'POST'])
    ;

    $routes->add('post_show', '/{id}')
        ->controller(BlogPostShowAction::class)
        ->methods(['GET'])
    ;

    $routes->add('post_edit', '/{id}/edit')
        ->controller(BlogPostEditAction::class)
        ->methods(['GET', 'POST'])
    ;

    $routes->add('post_delete', '/{id}')
        ->controller(BlogPostDeleteAction::class)
        ->methods(['DELETE'])
    ;
};
