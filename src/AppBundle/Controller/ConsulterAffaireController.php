<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Affaire;
use AppBundle\Entity\Devis;
use AppBundle\Entity\Facture;
use AppBundle\Entity\Commande;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * ConsulterAffaire controller.
 *
 * @Route("contact/consulter")
 */
class ConsulterAffaireController extends Controller
{
    /**
     * Lists all affaire entities.
     *
     * @Route("/", name="consulter_affaire_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $affaires = $em->getRepository('AppBundle:Affaire')->findAll();
        $affaires = $this->getUser()->getContact()->getAffaires();
        return $this->render('consulter/index.html.twig', array(
            'affaires' => $affaires,
        ));
    }

    /**
     * Finds and displays a affaire entity.
     *
     * @Route("/{id}", name="consulter_affaire_show")
     * @Method("GET")
     */
    public function showAction(Affaire $affaire)
    {
        return $this->render('consulter/show.html.twig', array(
            'affaire' => $affaire,
        ));
    }

    /**
     * Finds and displays a devi entity.
     *
     * @Route("/facture/{id}", name="consulter_facture_show")
     * @Method("GET")
     */
    public function showFactureAction(Facture $facture)
    {
        return $this->render('consulter/showFacture.html.twig', array(
            'facture' => $facture,
        ));
    }

    /**
     * Finds and displays a commande entity.
     *
     * @Route("/commande/{id}", name="consulter_commande_show")
     * @Method("GET")
     */
    public function showCommandeAction(Commande $commande)
    {
        return $this->render('consulter/showCommande.html.twig', array(
            'commande' => $commande,
        ));
    }

    /**
     * Finds and displays a devi entity.
     *
     * @Route("/devis/{id}", name="consulter_devis_show")
     * @Method("GET")
     */
    public function showDevisAction(Devis $devis)
    {
        return $this->render('consulter/showDevis.html.twig', array(
            'devis' => $devis,
        ));
    }
}
