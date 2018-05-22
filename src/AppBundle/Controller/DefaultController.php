<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Contact;
use AppBundle\Entity\InfoMailing;
use AppBundle\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/",name="homepage")
     */
    public function indexAction()
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->render('@App/Default/index.html.twig');
        }
        return $this->redirectToRoute('fos_user_security_login');
    }
    /**
     * @Route("/mailer",name="ffdsf")
     */
    public function mailertestAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contact = $em->getRepository(Contact::class)->find(2);
        $password = 'password';



        $mailers = $em->getRepository(InfoMailing::class)->findAll();
        $mailer = $mailers[0];
        $message =  \Swift_Message::newInstance()
            ->setSubject('Alerte Déclenché')
            ->setFrom($mailer->getEmailPrincipale())
            ->setTo('majdi.hannachi.17.10.1995@gmail.com')
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
        $this->get('mailer')->send($message);
        return $this->get('mailer')->send($message);
    }
}
