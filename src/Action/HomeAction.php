<?php

namespace App\Action;

use App\Http\Response;
use App\Responder\Responder;

final class HomeAction
{
    public function __construct(
        private Responder $responder,
    ) {}

    public function __invoke(): Response
    {
        return $this->responder->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
