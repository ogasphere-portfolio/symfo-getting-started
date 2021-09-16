<?php

namespace App\Controller;


use App\Entity\BirdModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(): Response
    {
        $birdModel = new BirdModel();
        $bird = $birdModel->getAll();
        return $this->render('cart/cart.html.twig', [
            'birds' => $bird,
        ]);
    }

     /**
     * @Route("/cart/{name}", name="addcart")
     */
    public function cartList($name, SessionInterface $session)
    {
        $birdModel = new BirdModel();
        $bird = $birdModel->getbyname($name);

          // si l'utilisateur a saisi un identifiant invalide
        // on récupère une valeur nulle dans la variable $bird
        // et on affiche une 404
        if ($bird === null) {
            // affiche une page 404 avec le message d'erreur fournit en argument
            throw $this->createNotFoundException('The oisal does not exist'); 
          
        };

        $this->addFlash('notice','L\'oiseau à été ajouté au panier!');

        // on ajoute l'oiseau en session
        $session->set('cart_bird', $bird);
       

       
       
       return $this->render('cart/cart.html.twig', ['birds' => $bird]); 
    }
    
}
