<?php

namespace App\Controller;


use App\Entity\BirdModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
   

     /**
     * @Route("/cart/", name="addcart")
     */
    // public function addtoCart(Request $requestObject,SessionInterface $session, BirdModel $birdModel) : response
    public function addtoCart(Request $requestObject,SessionInterface $session) : response
    {
        $birdModel = new BirdModel();
         // récupérer  les données (l'identifiant) depuis le formulaire
        // comme on est en method POST sur le formulaire, 
        // on utilise request->request
         // dump($requestObject);
         $birdId = $requestObject->request->get('bird_id'); // pour récupérer dans le tableau $_POST
         // $requestObject->query->get('toto'); // pour récupérer dans le tableau $_GET
 
         // validation des données
         $bird = $birdModel->get($birdId);
 
         if ($bird !== null)
         {
            
            // récupérer les données depuis la session
            // si il n'y a rien en session on récupére un tableau vide : [] 
            $currentCart = $session->get('cart', []);

                // si la clef n'existe pas 
            if (! isset($currentCart[$birdId])) {
                // alors on crée une entrée avec une quantité à 0
                
                $currentCart[$birdId] = [
                    'quantite' => 0,
                    'bird' => $bird
                ];
            }
            // à partir de cette ligne il y a forcément une entrée pour notre birdId
            // dans tout les cas on incrémente de 1 la quantité
            $currentCart[$birdId]['quantite']++;

            // écraser l'ancien panier avec le tableau que l'on vient de modifier
            // ajout dans la session
            $session->set('cart', $currentCart);

         }
 
        $this->addFlash('notice','L\'oiseau à été ajouté au panier!');

        // on ajoute l'oiseau en session
        $session->set('cart_bird', $bird);
       

       
       
       // on redirige vers la meme page
        return $this->redirectToRoute('cart_show');
    }
    
/**
     * display cart
     *
     * @Route("/cart/show", name="cart_show")
     */
    public function show(SessionInterface $session) {

        $session->get('cart');
        return $this->render('cart/cart.html.twig', [
            'cart' => $session->get('cart', []),
        ]);
      

    }
}
