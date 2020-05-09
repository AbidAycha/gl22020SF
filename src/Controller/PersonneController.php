<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Entity\Personne;
use App\Entity\Section;
use App\Entity\SocialMedia;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PersonneController
 * @package App\Controller
 * @Route("/personne")
 */
class PersonneController extends AbstractController
{
    /**
     * @Route("/", name="personne")
     */
    public function index(Request $request)
    {
        $page = $request->query->get('page') ?? 1;
        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $nbEnregistrements = $repository->count(array());
        $nbPage = ($nbEnregistrements % 10) ? ($nbEnregistrements / 10) + 1 : ($nbEnregistrements / 10);
        $personnes = $repository->findBy([], array('id' => 'DESC'), 10, ($page - 1) * 10);

        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
            'nbPage' => $nbPage
        ]);
    }

    /**
     * @Route("/delete/{id}", name="personne.delete")
     */
    public function deletePersonne($id)
    {
        /*
         * 1- Récupérer la personne d'id $id
         *  2- Si existe je le supprime et j'ajoute un flash de succès
         *  3- Sinon j'ajoute flash erreur
        */
        $repository = $this->getDoctrine()->getRepository(Personne::class);
        $personne = $repository->find($id);
        if (!$personne) {
            $this->addFlash('error', 'La suppression a échouée. Personne innexistante');
        } else {
            $manager = $this->getDoctrine()->getManager();
            // Ajoute la requete de suppression dans la transaction
            $manager->remove($personne);

            // Lance le commit de la transaction
            $manager->flush();
            $this->addFlash('success', 'Personne supprimée avec succès');
        }
        return $this->redirectToRoute('personne');
    }

    /**
     * @Route("/filter/{min}/{max}", name="get.personne.age")
     */
    public function getPersonnesByAge($min, $max) {
        $repository = $this->getDoctrine()->getRepository(Personne::class);

        $personnes = $repository->personnesInIntervalAge($min, $max);

        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes
        ]);
    }

    /**
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/add", name="personne.add")
     */
    public function addPersonne(EntityManagerInterface $manager)  {
        $personne = new Personne();
        $personne->setFirstname('aymen');
        $personne->setName('sellaouti');
        $personne->setAge(37);
        $personne->setCin(123460);
        $personne->setPath('as.jpg');
        $personne->setJob('Teacher');

        $socialMedia = new SocialMedia();
        $socialMedia->setFb('FB');
        $socialMedia->setLinkedIn('LinkedIn');

        $personne->setSocialMedia($socialMedia);
        $cours = new Cours();
        $cours->setDesignation('Web');
        $cours2 = new Cours();
        $cours2->setDesignation('Algo');
        $manager->persist($cours);
        $manager->persist($cours2);

        $section = new Section();
        $section->setDesignation('GL');

        $manager->persist($section);

        $personne->addCour($cours);
        $personne->addCour($cours2);

        $personne->setSection($section);

        $manager->persist($personne);

        $manager->flush();

//        return $this->forward('App\\Controller\\PersonneController::index');
        return $this->redirectToRoute('personne');
    }
}
