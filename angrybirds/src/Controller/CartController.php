<?php

namespace App\Controller;


use App\Model\BirdModel;
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

            $this->addFlash('success', "Ok oiseau {$bird['name']} ajouté !");

         }     
        
        else {
            // renvoyer une 404
            // ajouter un message flash
           $this->addFlash("error", "Oiseau non trouvé pour l'identifiant : [{$birdId}]");
        }
 
        

       
       

       
       
       // on redirige vers la meme page
        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("/cart/remove", name="cart_remove")
     */
    public function removeItem(Request $requestObject,  SessionInterface $session): Response
    {
        $birdModel = new BirdModel();
        $birdId = $requestObject->request->get('bird_id'); // pour récupérer dans le tableau $_POST
        $bird = $birdModel->get($birdId);
        if ($bird !== null)
        {
            $currentCart = $session->get('cart', []);

            // si la clef existe
            if ( isset($currentCart[$birdId])) {
   
                // dans tout les cas on décrémente de 1 la quantité
                $currentCart[$birdId]['quantite'] --;
    
                // si la quantité est inférieure ou égale 0 alors on supprime la ligne du panier
                if ($currentCart[$birdId]['quantite'] <= 0)
                {
                    unset($currentCart[$birdId]);
                }
                $this->addFlash('warning', 'un élément a été retiré du panier');
                $session->set('cart', $currentCart);
            }
            else 
            {
                $this->addFlash('warning', 'Cet oiseau n\'est pas dans le panier');
            }
        }
        else 
        {
            $this->addFlash("danger", "Cet oiseau n'existe pas");
        }

        // todo rediriger vers la page qui a appeler la méthode
        // on redirige vers la meme page
        return $this->redirectToRoute('cart_show');
    }

    /**
     * @Route("/cart/delete", name="cart_delete")
     */
    public function deleteItem(Request $requestObject,  SessionInterface $session): Response
    {
        $birdModel = new BirdModel();
        $birdId = $requestObject->request->get('bird_id'); // pour récupérer dans le tableau $_POST
        $bird = $birdModel->get($birdId);

        if ($bird !== null)
        {
            $currentCart = $session->get('cart', []);

            // si la clef existe
            if ( isset($currentCart[$birdId])) {
   
                // on supprime directement la ligne
                unset($currentCart[$birdId]);
                $this->addFlash('danger', 'Oiseau supprimé du panier');
                $session->set('cart', $currentCart);
            }
        }

        // après avoir traité un formulaire on fait une redirection
        // pour éviter qu'un F5 relance tout le traitement de l'ancien formulaire

        return $this->redirectToRoute('cart_show');
        // return $this->render('cart/show.html.twig', [
        //     'cart' => $currentCart,
        // ]);
        
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
