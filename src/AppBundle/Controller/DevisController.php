<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Affaire;
use AppBundle\Entity\Devis;
use AppBundle\Entity\DevisProduit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Devi controller.
 *
 * @Route("vente/devis")
 */
class DevisController extends Controller
{
    /**
     * Lists all devi entities.
     *
     * @Route("/", name="devis_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $deviss = $em->getRepository('AppBundle:Devis')->findAll();

        return $this->render('devis/index.html.twig', array(
            'deviss' => $deviss,
        ));
    }

    /**
     * Creates a new devi entity.
     *
     * @Route("/new/{id}", name="devis_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,Affaire $affaire = null)
    {
        $devis = new Devis($this->getUser());
        $form = $this->createForm('AppBundle\Form\DevisType', $devis);
        if($affaire){
            $form->remove('affaire');
            $affaire->setDevis($devis);
        }
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $prixtotal = 0;
            foreach ($devis->getDevisProduits() as $devisProduit){
                $prixtotal += $devisProduit->getQuantite() * $devisProduit->getProduit()->getPrixUnit();
            }
            foreach ($form->get('services')->getData() as $service) {
                $devis->addService($service);
                $prixtotal += $service->getPrix();
            }
            $devis->setPrixtotal($prixtotal);
            $em->persist($devis);
            $em->flush();
            /*
         $mailers = $em->getRepository(InfoMailing::class)->findAll();
         $mailer = $mailers[0];
         $message =  \Swift_Message::newInstance()
             ->setSubject('Alerte Déclenché')
             ->setFrom($mailer->getEmailPrincipale())
             ->setTo($devis->getAffaire()->getContact()->getEmail())
             ->setBody(
                 $this->renderView(

                     'mails/devis.html.twig',
                     array(

                         'devis' => $devis
                     )
                 ),
                 'text/html'
             )
         ;
         $this->get('mailer')->send($message);*/
            return $this->redirectToRoute('devis_show', array('id' => $devis->getId()));
        }

        return $this->render('devis/new.html.twig', array(
            'devis' => $devis,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a devi entity.
     *
     * @Route("/{id}", name="devis_show")
     * @Method("GET")
     */
    public function showAction(Devis $devis)
    {
        $deleteForm = $this->createDeleteForm($devis);

        return $this->render('devis/show.html.twig', array(
            'devis' => $devis,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing devi entity.
     *
     * @Route("/{id}/edit", name="devis_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Devis $devis)
    {
        $deleteForm = $this->createDeleteForm($devis);
        $editForm = $this->createForm('AppBundle\Form\DevisType', $devis);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em =  $this->getDoctrine()->getManager() ;
            $prixtotal = 0;
            foreach ($devis->getDevisProduits() as $devisProduit){
                $prixtotal += $devisProduit->getQuantite() * $devisProduit->getProduit()->getPrixUnit();
            }
            foreach ($editForm->get('services')->getData() as $service) {
                $devis->addService($service);
                $prixtotal += $service->getPrix();
            }
            foreach ($devis->getServices() as $service) {

                $prixtotal += $service->getPrix();
                $em->persist($service);

            }
            $oldProduits = $em->getRepository(DevisProduit::class)->findBy(['devis'=>$devis]);

           /* foreach ($oldProduits as $dProduit) {
                if (false === ($editForm->get('devisProduits')->getData())->contains($dProduit)) {
                    $devis->getDevisProduits()->removeElement($dProduit);
                    $em->remove($dProduit);
                }

            }*/

            $devis->setPrixtotal($prixtotal);
            $em->persist($devis);

            $em->flush();

            return $this->redirectToRoute('devis_show', array('id' => $devis->getId()));
        }

        return $this->render('devis/edit.html.twig', array(
            'devis' => $devis,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a devi entity.
     *
     * @Route("/{id}", name="devis_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Devis $devis)
    {
        $form = $this->createDeleteForm($devis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($devis);
            $em->flush($devis);
        }

        return $this->redirectToRoute('devis_index');
    }

    /**
     * Creates a form to delete a devi entity.
     *
     * @param Devis $devis The devi entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Devis $devis)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('devis_delete', array('id' => $devis->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
