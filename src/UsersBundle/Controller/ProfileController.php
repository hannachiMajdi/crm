<?php


namespace UsersBundle\Controller;



use UsersBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UsersBundle\Form\UserType;

class ProfileController  extends Controller
{
    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/profile/modifier", name="profile_modifier")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $contact = null;
        $user = $this->getUser();
        if($this->getUser()->getContact()){
            $contact = $this->getUser()->getContact();
            // $deleteForm = $this->createDeleteForm($user);
            $editForm = $this->createForm('AppBundle\Form\ContactType', $contact);
            $editForm->add('user',UserType::class,['label'=>false]);
            $userform  = $editForm->get('user');
            $userform->remove('roles');
            $userform->remove('email');
            $editForm->remove('username');
        }else{
            $editForm = $this->createForm('UsersBundle\Form\UserType', $user);
            $editForm->remove('roles');
        }


        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if($this->getUser()->getContact()){
                $user->setEmail($contact->getEmail());
            }
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
            $user->setPassword($encoder->encodePassword($user->getPlainPassword(),$user->getSalt()));
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','votre compte Modifié');
            return $this->redirectToRoute('fos_user_profile_show');
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'contact'=>$contact,
            'edit_form' => $editForm->createView(),
            // 'delete_form' => $deleteForm->createView(),
        ));
    }

}