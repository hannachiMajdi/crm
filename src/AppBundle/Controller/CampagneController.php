<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Campagne;
use AppBundle\Entity\Prospect;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Campagne controller.
 *
 * @Route("commercial/campagne")
 */
class CampagneController extends Controller
{
    /**
     * Lists all campagne entities.
     *
     * @Route("/", name="campagne_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $campagnes = $em->getRepository('AppBundle:Campagne')->findAll();

        return $this->render('campagne/index.html.twig', array(
            'campagnes' => $campagnes,
        ));
    }

    /**
     * Creates a new campagne entity.
     *
     * @Route("/new", name="campagne_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $campagne = new Campagne($this->getUser());
        $form = $this->createForm('AppBundle\Form\CampagneType', $campagne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form['prospects']->getData() as $prospect ){
            $campagne->addProspect($prospect);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($campagne);
            $em->flush();
            $this->addFlash('success','Campagne publicitaire ajouté');
            return $this->redirectToRoute('campagne_show', array('id' => $campagne->getId()));
        }
        $em = $this->getDoctrine()->getManager();

        $prospects = $em->getRepository('AppBundle:Prospect')->findAll();

        return $this->render('campagne/new.html.twig', array(
            'campagne' => $campagne,
            'form' => $form->createView(),
    ));
    }

    /**
     * Finds and displays a campagne entity.
     *
     * @Route("/{id}", name="campagne_show")
     * @Method("GET")
     */
    public function showAction(Campagne $campagne)
    {
        $deleteForm = $this->createDeleteForm($campagne);

        return $this->render('campagne/show.html.twig', array(
            'campagne' => $campagne,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing campagne entity.
     *
     * @Route("/{id}/edit", name="campagne_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Campagne $campagne)
    {
        $deleteForm = $this->createDeleteForm($campagne);
        $editForm = $this->createForm('AppBundle\Form\CampagneType', $campagne);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('campagne_show', array('id' => $campagne->getId()));
        }

        return $this->render('campagne/edit.html.twig', array(
            'campagne' => $campagne,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a campagne entity.
     *
     * @Route("/{id}", name="campagne_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Campagne $campagne)
    {
        $form = $this->createDeleteForm($campagne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($campagne);
            $em->flush($campagne);
        }

        return $this->redirectToRoute('campagne_index');
    }

    /**
     * Creates a form to delete a campagne entity.
     *
     * @param Campagne $campagne The campagne entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Campagne $campagne)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('campagne_delete', array('id' => $campagne->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
