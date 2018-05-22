<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Affaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Affaire controller.
 *
 * @Route("vente/affaire")
 */
class AffaireController extends Controller
{
    /**
     * Lists all affaire entities.
     *
     * @Route("/", name="affaire_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $affaires = $em->getRepository('AppBundle:Affaire')->findAll();

        return $this->render('affaire/index.html.twig', array(
            'affaires' => $affaires,
        ));
    }

    /**
     * Creates a new affaire entity.
     *
     * @Route("/new", name="affaire_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $affaire = new Affaire($this->getUser());
        $form = $this->createForm('AppBundle\Form\AffaireType', $affaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($affaire);
            $em->flush($affaire);

            return $this->redirectToRoute('affaire_show', array('id' => $affaire->getId()));
        }

        return $this->render('affaire/new.html.twig', array(
            'affaire' => $affaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a affaire entity.
     *
     * @Route("/{id}", name="affaire_show")
     * @Method("GET")
     */
    public function showAction(Affaire $affaire)
    {
        $deleteForm = $this->createDeleteForm($affaire);

        return $this->render('affaire/show.html.twig', array(
            'affaire' => $affaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing affaire entity.
     *
     * @Route("/{id}/edit", name="affaire_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Affaire $affaire)
    {
        $deleteForm = $this->createDeleteForm($affaire);
        $editForm = $this->createForm('AppBundle\Form\AffaireType', $affaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('affaire_show', array('id' => $affaire->getId()));
        }

        return $this->render('affaire/edit.html.twig', array(
            'affaire' => $affaire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a affaire entity.
     *
     * @Route("/{id}", name="affaire_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Affaire $affaire)
    {
        $form = $this->createDeleteForm($affaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($affaire);
            $em->flush($affaire);
        }

        return $this->redirectToRoute('affaire_index');
    }

    /**
     * Creates a form to delete a affaire entity.
     *
     * @param Affaire $affaire The affaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Affaire $affaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('affaire_delete', array('id' => $affaire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
