<?php




namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class BirdsController extends AbstractController
{
    

    /**
     * Undocumented function
     *
     * @Route("/", name="home")
     */
    public function list() : Response
    { 
        include './../public//files//data.php';
        return $this->render('home.html.twig', ['birds' => $birds]);
    }

    /**
     * @route("/bird/{id}", methods={"GET","HEAD"})", name="bird_content")
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        include './../public//files//data.php';
        return $this->render('showbird.html.twig', ['birds' => $birds[$id]]); 
    }
}
