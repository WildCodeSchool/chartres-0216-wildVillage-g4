<?php

namespace AppBundle\Controller;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Entity\Datauser;
use AppBundle\Entity\User;
use AppBundle\Entity\Link;
use AppBundle\Entity\Message;
use DateTime;
    /**
     * @Route("/", name="profil")
     */

class UserController extends Controller
{
    public function showProfilAction (Request $request)
    {
        $user = $this -> getUser();
        $userid = $user -> getId();
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Datauser');
        $datauser = $repository->findOneById_user($userid);
        echo "<br/> Username ";
        echo $user->getUsername();
        echo "<br/> Email ";
        echo $user->getEmail();
        echo "<br/> Age ";
        echo $datauser->getAge();
        return $this->render('default/profil.html.twig', array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    public function modifyAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $firstname = $request->request->get('firstname');
        $surname = $request->request->get('surname');


        $user = $this ->getUser();

        $repository = $em->getRepository('AppBundle:Datauser')->findOneById_user($user->getId());

        $repository->setFirstname($firstname);
        $repository->setSurname($surname);

        $em->persist($repository);
        $em->flush();
        
        return $this->render('default/profil.html.twig', array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
    public function messagerieAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $receive = $request->request->get('receive');
        $content = $request->request->get('content');
        $user = $this -> getUser();
        
        $idreceive = $user ->getId();
        $message = $em->getRepository('AppBundle:Message')->findOneById_send($user->getId());

        echo $user->getUsername();


        return $this -> render('default/messagerie.html.twig');
    }
    public function sendmsgAction (Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $user = $this -> getUser();
        
        $receive = $request->request->get('receive');
        $content = $request->request->get('content');

        $idreceive = $user ->getId();

        $message = new Message();
        $message->setIdSend($user->getId());
        $message->setIdReceive($idreceive);
        $message->setContent($content);
        $message->setDate(new DateTime());

        
        $em->persist($message);
        $em->flush();
        return $this -> render('default/messagerie.html.twig');
    }
}