<?php

namespace App\Controller;
use App\Model\BirdModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BirdsController extends AbstractController
{
    
    /**
     * téléchargement du calendrier
     *
     * @Route("/calendar", name="calendar")
     */
    public function calendar() {

        // load the file from the filesystem
        $file = new File('files/angry_birds_2015_calendar.pdf');
        // lancer le téléchargment du fichier
        // return $this->file(__DIR__ . '/../../public/files/angry_birds_2015_calendar.pdf');

        // display the file contents in the browser instead of downloading it
         return $this->file($file, 'my_invoice.pdf', ResponseHeaderBag::DISPOSITION_INLINE);
    }

    

    /**
     * Undocumented function
     *
     * @Route("/", name="home")
     */
    public function list(SessionInterface $session) : Response
    { 
        $birdModel = new BirdModel();
        $birds = $birdModel->getAll();
        $lastBird = $session->get('last_bird');
        
        /*
        la méthode render cherche les templates à partir du dossier templates
        */

        return $this->render('bird/home.html.twig', [
            'birds' => $birds,
            'last_bird' => $lastBird,
        ]);
    }

    /**
     * @route("/bird/{id}", name="bird_content", methods={"GET","HEAD"})"
     * @param  mixed $id
     * @return void
     */
    public function show($id, SessionInterface $session) 
    {
        $birdModel = new BirdModel();
        $bird = $birdModel->get($id);
        
          // si l'utilisateur a saisi un identifiant invalide
        // on récupère une valeur nulle dans la variable $bird
        // et on affiche une 404
        if ($bird === null) {
            // affiche une page 404 avec le message d'erreur fournit en argument
            throw $this->createNotFoundException('The oisal does not exist'); 
          
        }
            // on ajoute l'oiseau en session
            $session->set('last_bird', $bird);
            return $this->render('bird/showbird.html.twig', [
                'bird' => $bird,
                'bird_id' => $id,
            ]); 
    }

    /**
     * Undocumented function
     *
     * @Route("/bird/{birdName}", name="bird_show_name", requirements={"birdName"="[\w ]+"})
     */
    public function showName($birdName) {
        $birdModel = new BirdModel();
        $bird = $birdModel->getByName($birdName);
        
        if ($bird === null) {
            throw $this->createNotFoundException('The oisal does not exist');        
        }

        return $this->render('bird/showbird.html.twig', [
            'bird' => $bird,
        ]);
    }
}


