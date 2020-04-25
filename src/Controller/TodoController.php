<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    /**
     * @Route("/todo", name="todo")
     */
    public function index(Request $request)
    {
        $session = $request->getSession();
        /*
         * Vérifier si les todos existe dans la session
         *      Si non 
         *          on les ajoute dans la session
         *          message Flash de bienvenu
         *      Affiche
         * */
        if (!$session->has('todos')) {
            $todos = array(
                'achat' => 'acheter clé usb',
                'cours' => 'Finaliser mon cours',
                'correction' => 'corriger mes examens');
            $session->set('todos', $todos);
            $this->addFlash('info', 'Session initialisée avec succès la liste des todos a été ajoutée');
        }
        return $this->render('todo/index.html.twig');
    }

    /**
     * @Route("/todo/add/{name}/{description}", name="todo.add")
     */
    public function add(SessionInterface $session, $name, $description) {
        /**
         * vérifier si la session est crée
         *      Si oui
         *          si on a deja un todo avec le meme nom
         *              si oui
         *                  erreur
         *              sinon
         *                  ajout
         *     Si non
         *          erreur
         */
        If ($session->has('todos')) {
            $todos = $session->get('todos');
            if(isset($todos[$name])) {
                $this->addFlash('error', "le Todo $name existe déjà");
            } else {
                $todos[$name]=$description;
                $session->set('todos', $todos);
                $this->addFlash('success', "le Todo $name ajouté avec succès");
            }
        } else {
            $this->addFlash('error', "Vous devez initiliser d'abord la session");
        }
        return $this->redirectToRoute('todo');
    }
}
