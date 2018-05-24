<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Affaire;
use AppBundle\Entity\Campagne;
use AppBundle\Entity\Category;
use AppBundle\Entity\Commande;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Devis;
use AppBundle\Entity\Facture;
use AppBundle\Entity\InfoMailing;
use AppBundle\Entity\Organisation;
use AppBundle\Entity\Product;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Prospect;
use AppBundle\Entity\Service;
use AppBundle\Entity\TicketClient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="homepage")
     */
    public function indexAction()
    {
    /*    $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->render('@App/Default/index.html.twig');

        }*/
    if($this->isGranted('ROLE_VENTE')){
        $em = $this->getDoctrine()->getManager();
        $produits = count($em->getRepository(Produit::class)->findAll());
        $services = count($em->getRepository(Service::class)->findAll());
        $affaires = count($em->getRepository(Affaire::class)->findAll());
        $tickets = count($em->getRepository(TicketClient::class)->findAll());

        return $this->render('@App/Default/index.html.twig',
            array(
                'produits'=>$produits,
                'services'=>$services,
                'affaires'=>$affaires,
                'tickets'=>$tickets,
            ));
    }
        if($this->isGranted('ROLE_COMMERCIAL')){
            $em = $this->getDoctrine()->getManager();
            $Organisations = count($em->getRepository(Organisation::class)->findAll());
            $Contacts = count($em->getRepository(Contact::class)->findAll());
            $Prospects = count($em->getRepository(Prospect::class)->findAll());
            $Campagnes = count($em->getRepository(Campagne::class)->findAll());
            $tickets = count($em->getRepository(TicketClient::class)->findAll());

            return $this->render('@App/Default/index.html.twig',
                array(
                    'Organisations'=>$Organisations,
                    'Contacts'=>$Contacts,
                    'Prospects'=>$Prospects,
                    'Campagnes'=>$Campagnes,
                    'tickets'=>$tickets,
                ));
        }
        if($this->isGranted('ROLE_ADMIN')){
            $em = $this->getDoctrine()->getManager();
            $produits = count($em->getRepository(Produit::class)->findAll());
            $services = count($em->getRepository(Service::class)->findAll());
            $affaires = count($em->getRepository(Affaire::class)->findAll());
            $Organisations = count($em->getRepository(Organisation::class)->findAll());
            $Contacts = count($em->getRepository(Contact::class)->findAll());
            $Prospects = count($em->getRepository(Prospect::class)->findAll());
            $Campagnes = count($em->getRepository(Campagne::class)->findAll());
            $tickets = count($em->getRepository(TicketClient::class)->findAll());

            return $this->render('@App/Default/index.html.twig',
                array(
                    'produits'=>$produits,
                    'services'=>$services,
                    'affaires'=>$affaires,
                    'Organisations'=>$Organisations,
                    'Contacts'=>$Contacts,
                    'Prospects'=>$Prospects,
                    'Campagnes'=>$Campagnes,
                    'tickets'=>$tickets,
                ));
        }
        if($this->isGranted('ROLE_CONTACT')){
            $em = $this->getDoctrine()->getManager();
            $affaires = count($em->getRepository(Affaire::class)->findBy(['contact'=>$this->getUser()]));

            $tickets = count($em->getRepository(TicketClient::class)->findAll());

            return $this->render('@App/Default/index.html.twig',
                array(

                    'affaires'=>$affaires,

                    'tickets'=>$tickets,
                ));
        }
        return $this->redirectToRoute('fos_user_security_login');
    }

}
