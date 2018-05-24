<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Entity\InfoMailing;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use UsersBundle\Entity\User;

/**
 * Contact controller.
 *
 * @Route("commercial/contact")
 */
class ContactController extends Controller
{
    /**
     * Lists all contact entities.
     *
     * @Route("/", name="contact_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contacts = $em->getRepository('AppBundle:Contact')->findAll();

        return $this->render('contact/index.html.twig', array(
            'contacts' => $contacts,
        ));
    }

    /**
     * Creates a new contact entity.
     *
     * @Route("/new", name="contact_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm('AppBundle\Form\ContactType', $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // user creation
            $username = $form->get('username')->getData();
            $user = new User();
            $user->setUsername($username);
            $user->setUsernameCanonical(strtolower($username));
            $user->setEmail($contact->getEmail());
            $user->setEmailCanonical(strtolower($contact->getEmail()));
            $tokenGenerator = $this->container->get('fos_user.util.token_generator');
            $password = substr($tokenGenerator->generateToken(), 0, 12);
            $user->setPlainPassword($password);
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
            $user->setPassword($encoder->encodePassword($user->getPlainPassword(),$user->getSalt()));
            $user->setEnabled(true);
            $user->addRole('ROLE_CONTACT');
            //fin
            $contact->setUser($user);
            $em->persist($contact);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success','Contact ajouté avec le mots de passe '.$password);
            var_dump($password);
/*
            $mailers = $em->getRepository(InfoMailing::class)->findAll();
            $mailer = $mailers[0];
            $message =  \Swift_Message::newInstance()
                ->setSubject('Alerte Déclenché')
                ->setFrom($mailer->getEmailPrincipale())
                ->setTo($contact->getEmail())
                ->setBody(
                    $this->renderView(

                        'mails/password.html.twig',
                        array(
                            'contact'=>$contact,
                            'password' => $password
                        )
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);*/
            return $this->redirectToRoute('contact_show', array('id' => $contact->getId()));
        }

        return $this->render('contact/new.html.twig', array(
            'contact' => $contact,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a contact entity.
     *
     * @Route("/{id}", name="contact_show")
     * @Method("GET")
     */
    public function showAction(Contact $contact)
    {
        $deleteForm = $this->createDeleteForm($contact);

        return $this->render('contact/show.html.twig', array(
            'contact' => $contact,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing contact entity.
     *
     * @Route("/{id}/edit", name="contact_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Contact $contact)
    {
        $deleteForm = $this->createDeleteForm($contact);
        $editForm = $this->createForm('AppBundle\Form\ContactType', $contact);
        if($contact->getUser())
        $editForm->get('username')->setData($contact->getUser()->getUsername());
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $user = $contact->getUser();
            // user creation
            if(is_null($contact->getUser())){

                $user = new User();
                $tokenGenerator = $this->container->get('fos_user.util.token_generator');
                $password = substr($tokenGenerator->generateToken(), 0, 12);
                $user->setPlainPassword($password);
                $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
                $user->setPassword($encoder->encodePassword($user->getPlainPassword(),$user->getSalt()));
                $user->setEnabled(true);
                $user->addRole('ROLE_CONTACT');
                $contact->setUser($user);
            }

            $username = $editForm->get('username')->getData();

            $user->setUsername($username);
            $user->setUsernameCanonical(strtolower($username));
            $user->setEmail($contact->getEmail());
            $user->setEmailCanonical(strtolower($contact->getEmail()));
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Contact modifié');
            /*
            $mailers = $em->getRepository(InfoMailing::class)->findAll();
            $mailer = $mailers[0];
            $message =  \Swift_Message::newInstance()
                ->setSubject('Alerte Déclenché')
                ->setFrom($mailer->getEmailPrincipale())
                ->setTo($contact->getEmail())
                ->setBody(
                    $this->renderView(

                        'mails/password.html.twig',
                        array(
                            'contact'=>$contact,
                            'password' => $password
                        )
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);*/
            return $this->redirectToRoute('contact_show', array('id' => $contact->getId()));
        }

        return $this->render('contact/edit.html.twig', array(
            'contact' => $contact,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a contact entity.
     *
     * @Route("/{id}", name="contact_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Contact $contact)
    {
        $form = $this->createDeleteForm($contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contact);
            $em->flush($contact);
            $this->addFlash('error','Contact supprimé');
        }

        return $this->redirectToRoute('contact_index');
    }

    /**
     * Creates a form to delete a contact entity.
     *
     * @param Contact $contact The contact entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contact $contact)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('contact_delete', array('id' => $contact->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
