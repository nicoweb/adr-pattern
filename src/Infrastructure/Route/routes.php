<?php

declare(strict_types=1);

use App\Action\HomeAction;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes) {
    $routes->import(__DIR__.'/blog_post.php', 'php')
        ->prefix('/post')
        ->namePrefix('blog_')
    ;

    $routes->import(__DIR__.'/author.php', 'php')
        ->prefix('/author')
        ->namePrefix('author_')
    ;

    $routes->add('home', '/')
        ->controller(HomeAction::class)
        ->methods(['GET'])
    ;
};
