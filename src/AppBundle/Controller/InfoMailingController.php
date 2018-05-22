<?php

namespace AppBundle\Controller;

use AppBundle\Entity\InfoMailing;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Infomailing controller.
 *
 * @Route("admin/infomailing")
 */
class InfoMailingController extends Controller
{
    /**
     * Lists all infoMailing entities.
     *
     * @Route("/", name="infomailing_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('infomailing_edit', array('id' => 1));

    }

    /**
     * Finds and displays a infoMailing entity.
     *
     * @Route("/{id}", name="infomailing_show")
     * @Method("GET")
     */
    public function showAction(InfoMailing $infoMailing)
    {
        return $this->render('infomailing/show.html.twig', array(
            'infoMailing' => $infoMailing,
        ));
    }

    /**
     * Displays a form to edit an existing infoMailing entity.
     *
     * @Route("/{id}/edit", name="infomailing_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, InfoMailing $infoMailing)
    {
        $editForm = $this->createForm('AppBundle\Form\InfoMailingType', $infoMailing);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('infomailing_show', array('id' => $infoMailing->getId()));
        }

        return $this->render('infomailing/edit.html.twig', array(
            'infoMailing' => $infoMailing,
            'edit_form' => $editForm->createView(),
        ));
    }
}
