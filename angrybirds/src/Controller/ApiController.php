<?php

namespace App\Controller;

use App\Model\BirdModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function list(): Response
    {

        $birdModel = new BirdModel();
        $birds = $birdModel->getAll();

        return $this->json( $birds);

      
    }
}
