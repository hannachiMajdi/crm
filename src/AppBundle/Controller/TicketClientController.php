<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TicketClient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use UsersBundle\Entity\User;
use UsersBundle\Form\UserType;

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
        if($this->isGranted('ROLE_CANDIDAT')){
            $form->remove('contact');
            $ticketClient->setContact($this->getUser());
        }

        $form->remove('etat');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $ticketClient->setEtat('en attente');
            $em->persist($ticketClient);
            $em->flush($ticketClient);
            $this->addFlash('success','ticket client ajouté');
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
            $editForm->remove('contact');
        }else{
            $editForm->remove('titre');
            $editForm->remove('description');
            $editForm->remove('date');
            $editForm->remove('type');
            $ticketClient->setUser($this->getUser());
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','ticket client modifié');
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
            $this->addFlash('error','ticket client supprimé');
        }

        return $this->redirectToRoute('ticketclient_index');
    }
    /**
     * Deletes a ticketClient entity.
     *
     * @Route("/{id}/renseigner", name="ticketclient_renseigner")
     * @Method({"GET", "POST"})
     */
    public function renseignerAction(Request $request, TicketClient $ticketClient)
    {
        $form = $this->createFormBuilder()
            ->add('agent',EntityType::class,
                array(
                    'class' => User::class,
                    )

            )->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
           $ticketClient->setUser($form->get('agent')->getData());
            $em->flush($ticketClient);
            $this->addFlash('success','ticket client renseignée');
            return $this->redirectToRoute('ticketclient_index');
        }

        return $this->render('ticketclient/renseigner.html.twig', array(
            'ticketClient' => $ticketClient,
            'form' => $form->createView(),

        ));
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
