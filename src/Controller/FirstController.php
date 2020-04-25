<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    /**
     * @Route("/first", name="first")
     */
    public function index()
    {
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
        ]);
    }

    /**
     * @Route("/gl",name="gl2_presentation")
     */
    public function gl2(Request $request) {
        $response = new Response('<h1>Gl2</h1>');
        return $response;
    }

    /**
     * @param $name
     * @return Response
     * @Route("/hello/{name}", name="say.hello")
     */
    public function sayHello(Request $request, $name) {
        return $this->render('first/hello.html.twig', [
            'esm' => $name
        ]);
    }
}
