<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Organisation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Organisation controller.
 *
 * @Route("commercial/organisation")
 */
class OrganisationController extends Controller
{
    /**
     * Lists all organisation entities.
     *
     * @Route("/", name="organisation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $organisations = $em->getRepository('AppBundle:Organisation')->findAll();

        return $this->render('organisation/index.html.twig', array(
            'organisations' => $organisations,
        ));
    }

    /**
     * Creates a new organisation entity.
     *
     * @Route("/new", name="organisation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $organisation = new Organisation();
        $form = $this->createForm('AppBundle\Form\OrganisationType', $organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($organisation);
            $em->flush($organisation);
            $this->addFlash('success','Organisation Ajouté');
            return $this->redirectToRoute('organisation_show', array('id' => $organisation->getId()));
        }

        return $this->render('organisation/new.html.twig', array(
            'organisation' => $organisation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a organisation entity.
     *
     * @Route("/{id}", name="organisation_show")
     * @Method("GET")
     */
    public function showAction(Organisation $organisation)
    {
        $deleteForm = $this->createDeleteForm($organisation);

        return $this->render('organisation/show.html.twig', array(
            'organisation' => $organisation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing organisation entity.
     *
     * @Route("/{id}/edit", name="organisation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Organisation $organisation)
    {
        $deleteForm = $this->createDeleteForm($organisation);
        $editForm = $this->createForm('AppBundle\Form\OrganisationType', $organisation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('organisation_show', array('id' => $organisation->getId()));
        }

        return $this->render('organisation/edit.html.twig', array(
            'organisation' => $organisation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a organisation entity.
     *
     * @Route("/{id}", name="organisation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Organisation $organisation)
    {
        $form = $this->createDeleteForm($organisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($organisation);
            $em->flush($organisation);
        }

        return $this->redirectToRoute('organisation_index');
    }

    /**
     * Creates a form to delete a organisation entity.
     *
     * @param Organisation $organisation The organisation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Organisation $organisation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('organisation_delete', array('id' => $organisation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
