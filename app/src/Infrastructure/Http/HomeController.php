<?php

namespace Infrastructure\Http;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractHttpController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function me(Request $request): Response
    {
        return $this->render('home/home.html.twig', [
            'form' => $request->get('form'),
            'form_errors' => $request->get('form_errors', []),
        ]);
    }
}
