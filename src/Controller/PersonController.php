<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class PersonController extends AbstractController{
    // Voici l'uri associé à cette fonction
    // Bel 3arbi ki tal9a uri /person 3ayet lel méthode index eli fel Classe PersonController
    #[Route('/person', name: 'app_person')]
    public function index(): Response
    {
//          $response = new Response("<html><body><h1>Hello GLRT2</h1></body></html>");
//          return $response;
        return $this->render('person/index.html.twig', ["name" => "aymen"]);
    }

    // J'accepte ay route tebda eb hello ou ba3dha eli iji ama 3andha 2 segments
    #[Route('/hello/{name}', name: 'app_hello')]
    public function Hello(SessionInterface $session, $name): Response
    {
            $session->set('section',"GL RT");
//          $response = new Response("<html><body><h1>Hello GLRT2</h1></body></html>");
//          return $response;

            return $this->render('person/index.html.twig', ["name" => $name]);
    }
}
