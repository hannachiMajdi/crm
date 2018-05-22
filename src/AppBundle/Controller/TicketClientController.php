<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TicketClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Ticketclient controller.
 *
 * @Route("ticketclient")
 */
class TicketClientController extends Controller
{
    /**
     * Lists all ticketClient entities.
     *
     * @Route("/", name="ticketclient_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ticketClients = $em->getRepository('AppBundle:TicketClient')->findAll();
        if($this->isGranted('ROLE_CONTACT'))
            $ticketClients = $this->getUser()->getContact()->getTicketClients();
        return $this->render('ticketclient/index.html.twig', array(
            'ticketClients' => $ticketClients,
        ));
    }

    /**
     * Creates a new ticketClient entity.
     *
     * @Route("/new", name="ticketclient_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $ticketClient = new Ticketclient($this->getUser());
        $form = $this->createForm('AppBundle\Form\TicketClientType', $ticketClient);
        $form->remove('etat');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ticketClient->setEtat('en attente');
            $em->persist($ticketClient);
            $em->flush($ticketClient);

            return $this->redirectToRoute('ticketclient_show', array('id' => $ticketClient->getId()));
        }

        return $this->render('ticketclient/new.html.twig', array(
            'ticketClient' => $ticketClient,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ticketClient entity.
     *
     * @Route("/{id}", name="ticketclient_show")
     * @Method("GET")
     */
    public function showAction(TicketClient $ticketClient)
    {
        $deleteForm = $this->createDeleteForm($ticketClient);

        return $this->render('ticketclient/show.html.twig', array(
            'ticketClient' => $ticketClient,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ticketClient entity.
     *
     * @Route("/{id}/edit", name="ticketclient_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TicketClient $ticketClient)
    {
        $deleteForm = $this->createDeleteForm($ticketClient);
        $editForm = $this->createForm('AppBundle\Form\TicketClientType', $ticketClient);
        $editForm->handleRequest($request);
        if($this->isGranted('ROLE_CONTACT')){
            $editForm->remove('etat');
        }else{
            $editForm->remove('titre');
            $editForm->remove('description');
            $editForm->remove('date');
            $editForm->remove('type');
            $ticketClient->setUser($this->getUser());
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ticketclient_edit', array('id' => $ticketClient->getId()));
        }

        return $this->render('ticketclient/edit.html.twig', array(
            'ticketClient' => $ticketClient,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ticketClient entity.
     *
     * @Route("/{id}", name="ticketclient_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TicketClient $ticketClient)
    {
        $form = $this->createDeleteForm($ticketClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ticketClient);
            $em->flush($ticketClient);
        }

        return $this->redirectToRoute('ticketclient_index');
    }

    /**
     * Creates a form to delete a ticketClient entity.
     *
     * @param TicketClient $ticketClient The ticketClient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TicketClient $ticketClient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ticketclient_delete', array('id' => $ticketClient->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
