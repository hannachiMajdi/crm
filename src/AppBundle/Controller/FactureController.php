<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Affaire;
use AppBundle\Entity\Facture;
use AppBundle\Entity\FactureProduit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Devi controller.
 *
 * @Route("vente/facture")
 */
class FactureController extends Controller
{
    /**
     * Lists all devi entities.
     *
     * @Route("/", name="facture_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $factures = $em->getRepository('AppBundle:Facture')->findAll();

        return $this->render('facture/index.html.twig', array(
            'factures' => $factures,
        ));
    }

    /**
     * Creates a new devi entity.
     *
     * @Route("/new/{id}", name="facture_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,Affaire $affaire = null)
    {
        $facture = new Facture($this->getUser());
        $form = $this->createForm('AppBundle\Form\FactureType', $facture);
        if($affaire){
            $form->remove('affaire');
            $affaire->setfacture($facture);
        }
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $prixtotal = 0;
            if($form->has('affaire')) $facture->setAffaire($form->get('affaire')->getData());
            foreach ($facture->getFactureProduits() as $factureProduit){
                $prixtotal += $factureProduit->getQuantite() * $factureProduit->getProduit()->getPrixUnit();
            }
            foreach ($form->get('services')->getData() as $service) {
                $facture->addService($service);
                $prixtotal += $service->getPrix();
            }
            $facture->setPrixtotal($prixtotal);
            $em->persist($facture);
            $em->flush();

            /*
         $mailers = $em->getRepository(InfoMailing::class)->findAll();
         $mailer = $mailers[0];
         $message =  \Swift_Message::newInstance()
             ->setSubject('Alerte Déclenché')
             ->setFrom($mailer->getEmailPrincipale())
             ->setTo($facture->getAffaire()->getContact()->getEmail())
             ->setBody(
                 $this->renderView(

                     'mails/facture.html.twig',
                     array(

                         'facture' => $facture
                     )
                 ),
                 'text/html'
             )
         ;
         $this->get('mailer')->send($message);*/
            return $this->redirectToRoute('facture_show', array('id' => $facture->getId()));
        }

        return $this->render('facture/new.html.twig', array(
            'facture' => $facture,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a devi entity.
     *
     * @Route("/{id}", name="facture_show")
     * @Method("GET")
     */
    public function showAction(Facture $facture)
    {
        $deleteForm = $this->createDeleteForm($facture);

        return $this->render('facture/show.html.twig', array(
            'facture' => $facture,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing devi entity.
     *
     * @Route("/{id}/edit", name="facture_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Facture $facture)
    {
        $deleteForm = $this->createDeleteForm($facture);
        $editForm = $this->createForm('AppBundle\Form\FactureType', $facture);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em =  $this->getDoctrine()->getManager() ;
            $prixtotal = 0;
            foreach ($facture->getFactureProduits() as $factureProduit){
                $prixtotal += $factureProduit->getQuantite() * $factureProduit->getProduit()->getPrixUnit();
            }
            foreach ($editForm->get('services')->getData() as $service) {
                $facture->addService($service);
                $prixtotal += $service->getPrix();
            }
            foreach ($facture->getServices() as $service) {

                $prixtotal += $service->getPrix();
                $em->persist($service);

            }
            $oldProduits = $em->getRepository(FactureProduit::class)->findBy(['facture'=>$facture]);

          /*  foreach ($oldProduits as $dProduit) {
                if (false === ($editForm->get('factureProduits')->getData())->contains($dProduit)) {
                    $facture->getFactureProduits()->removeElement($dProduit);
                    $em->remove($dProduit);
                }

            }*/

            $facture->setPrixtotal($prixtotal);
            $em->persist($facture);

            $em->flush();

            return $this->redirectToRoute('facture_show', array('id' => $facture->getId()));
        }

        return $this->render('facture/edit.html.twig', array(
            'facture' => $facture,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a devi entity.
     *
     * @Route("/{id}", name="facture_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Facture $facture)
    {
        $form = $this->createDeleteForm($facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($facture);
            $em->flush($facture);
        }

        return $this->redirectToRoute('facture_index');
    }

    /**
     * Creates a form to delete a devi entity.
     *
     * @param Facture $facture The devi entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Facture $facture)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('facture_delete', array('id' => $facture->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
