<?php

namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Entity\Post;
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
        return $this->render('default/profil.html.twig', array(
        		'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
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
        
        return $this->render('default/profil.html.twig', array(
        	'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    public function showPostsAction (Request $request)
    {
        $user = $this -> getUser();
        $userid = $user -> getId();
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Post');
        $posts = $repository->findById_user($userid);

        // Pour chaque message
        foreach ($posts as $post) {
	        echo "<br/><br/> Date: ";
	        // echo $post->getDate();
	        echo "<br/> idMsg: ";
	        echo $post->getId();
	        echo "<br/> idUser: ";
	        echo $post->getIdUser();
	        echo "<br/> Message: ";
	        echo $post->getContent();
        }
		return $this->render('default/profil.html.twig', array(
			'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));		
    }
    
    public function sendPostAction (Request $request)
    {
		$em = $this->getDoctrine()->getManager();
		$msg = $request->request->get('msg');
		$user = $this->getUser();

		$objpost = new Post();
		$objpost->setIdUser($user->getId());
		$objpost->setContent($msg);
		$objpost->setDate(new DateTime());
		$objpost->setIspublic(true);

		$em->persist($objpost);
		$em->flush();
		return $this->render('default/profil.html.twig', array(
			'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));		
	}
    
    public function messagerieAction (Request $request)
    {
        $user = $this -> getUser();
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Message');

        
        $messages = $repository->findByidReceive($user->getId());
        
        $messages_recus = [];
        foreach ($messages as $message) {
        	$msg_recu = [];
        	
        	$sender = $this->getDoctrine()->getRepository('AppBundle:User')->findOneByid($message->getidSend());
        	
	    	$msg_recu[] = array(
	    		'id' => $message->getId(),
	    		'idsent' => $message->getIdSenD(),
	    		'content' => $message->getContent(),
	    		'date' => $message->getDate(),
	    		'sender_username' => $sender->getUsername(),
	    	);

       		array_push($messages_recus, $msg_recu);
       		var_dump($messages_recus);

        }
        // $sent_messages = $repository->findByidSend($user->getId());

        return $this -> render('default/messagerie.html.twig', array(
        	'user'	 		=> $user,
        	'messages'		=> $messages_recus,
        	// 'sent_messages'	=> $sent_messages,
        ));
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