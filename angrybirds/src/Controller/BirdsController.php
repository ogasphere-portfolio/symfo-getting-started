<?php




namespace App\Controller;

use App\Entity\BirdModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BirdsController extends AbstractController
{
    
   
    /**
     * téléchargement du calendrier
     *
     * @Route("/calendar", name="calendar")
     */
    public function calendar() {
        // lancer le téléchargment du fichier
        return $this->file(__DIR__ . '/../../public/files/angry_birds_2015_calendar.pdf');
    }

    /**
     * Undocumented function
     *
     * @Route("/", name="home")
     */
    public function list() : Response
    { 
        
        $birdModel = new BirdModel();
        $birds = $birdModel->getAll();
        return $this->render('home.html.twig', ['birds' => $birds]);
    }

    /**
     * @route("/bird/{id}", name="bird_content", methods={"GET","HEAD"}, requirements={"id"="\d+"})"
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        $birdModel = new BirdModel();
        $birds = $birdModel->get($id);

          // si l'utilisateur a saisi un identifiant invalide
        // on récupère une valeur nulle dans la variable $bird
        // et on affiche une 404
        if ($birds === null) {
            // affiche une page 404 avec le message d'erreur fournit en argument
            throw $this->createNotFoundException('The oisal does not exist'); 
          
        }

        return $this->render('showbird.html.twig', ['birds' => $birds]); 
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

        return $this->render('showbird.html.twig', [
            'birds' => $bird,
        ]);
    }
}
