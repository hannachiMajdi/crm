<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Affaire;
use AppBundle\Entity\Commande;
use AppBundle\Entity\CommandeProduit;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Commande controller.
 *
 * @Route("vente/commande")
 */
class CommandeController extends Controller
{
    /**
     * Lists all commande entities.
     *
     * @Route("/", name="commande_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('AppBundle:Commande')->findAll();

        return $this->render('commande/index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**
     * Creates a new commande entity.
     *
     * @Route("/new", name="commande_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $commande = new Commande($this->getUser());
        $form = $this->createForm('AppBundle\Form\CommandeType', $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $prixtotal = 0;
            foreach ($commande->getCommandeProduits() as $commandeProduit){
                $prixtotal += $commandeProduit->getQuantite() * $commandeProduit->getProduit()->getPrixUnit();
            }
            foreach ($form->get('services')->getData() as $service) {
                $commande->addService($service);
                $prixtotal += $service->getPrix();
            }
            $commande->setPrixtotal($prixtotal);
            //creation de l'affaire

            $affaire = new Affaire($this->getUser());
            $affaire->setContact($form->get('contact')->getData());
            $affaire->setRef($commande->getRef());
            $affaire->setEtat('En attente');
            $commande->setAffaire($affaire);
            $em->persist($commande);
            $em->persist($affaire);
            $this->addFlash('success','commande crée');
            $this->addFlash('success','Affaire crée');
            $em->persist($commande);
            $em->flush();
            $this->addFlash('success','Commande Ajouté');
            /*
            $mailers = $em->getRepository(InfoMailing::class)->findAll();
            $mailer = $mailers[0];
            $message =  \Swift_Message::newInstance()
                ->setSubject('Alerte Déclenché')
                ->setFrom($mailer->getEmailPrincipale())
                ->setTo($commande->getAffaire()->getContact()->getEmail())
                ->setBody(
                    $this->renderView(

                        'mails/commande.html.twig',
                        array(

                            'commande' => $commande
                        )
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);*/
            return $this->redirectToRoute('commande_show', array('id' => $commande->getId()));
        }

        return $this->render('commande/new.html.twig', array(
            'commande' => $commande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commande entity.
     *
     * @Route("/{id}", name="commande_show")
     * @Method("GET")
     */
    public function showAction(Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);

        return $this->render('commande/show.html.twig', array(
            'commande' => $commande,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commande entity.
     *
     * @Route("/{id}/edit", name="commande_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('AppBundle\Form\CommandeType', $commande);
        $editForm->remove('contact');
        $editForm->handleRequest($request);

         $oldServices = new ArrayCollection();

         foreach ($commande->getServices() as $sv) {
             $oldServices->add($sv);
         }

         if ($editForm->isSubmitted() && $editForm->isValid()) {

             $prixtotal = 0;
             $em = $this->getDoctrine()->getManager();
             foreach ($commande->getcommandeProduits() as $commandeProduit){
                 $prixtotal += $commandeProduit->getQuantite() * $commandeProduit->getProduit()->getPrixUnit();
             }
             foreach ($editForm->get('services')->getData() as $service) {
                 $commande->addService($service);
                 $prixtotal += $service->getPrix();
             }
             foreach ($commande->getServices() as $service) {

                 $prixtotal += $service->getPrix();
                 $em->persist($service);

             }
             $oldProduits = $em->getRepository(CommandeProduit::class)->findBy(['commande'=>$commande]);

            /* foreach ($oldProduits as $dProduit){
                 if(false === ($editForm->get('commandeProduits')->getData())->contains($dProduit)){
                     $commande->getCommandeProduits()->removeElement($dProduit);
                     $em->remove($dProduit);
                 }

             }*/
             foreach ($editForm->get('services')->getData() as $dService){
                 if(! $oldServices->contains($dService))
                     $commande->removeService($dService);
             }



             $commande->setPrixtotal($prixtotal);
             $commande->getAffaire()->setRef($commande->getRef());
             $em->persist($commande);
             $em->flush();
             $this->addFlash('success','commande modifié');
             return $this->redirectToRoute('commande_show', array('id' => $commande->getId()));
         }

         return $this->render('commande/edit.html.twig', array(
             'commande' => $commande,
             'edit_form' => $editForm->createView(),
             'delete_form' => $deleteForm->createView(),
         ));
     }

     /**
      * Deletes a commande entity.
      *
      * @Route("/{id}", name="commande_delete")
      * @Method("DELETE")
      */
    public function deleteAction(Request $request, Commande $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush($commande);
            $this->addFlash('error','commande supprimé');
        }

        return $this->redirectToRoute('commande_index');
    }

    /**
     * Creates a form to delete a commande entity.
     *
     * @param Commande $commande The commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commande $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commande_delete', array('id' => $commande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
