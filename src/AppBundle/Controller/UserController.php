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
use AppBundle\Entity\Profil_user;
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
        echo "<br/>";
        echo $datauser->getFirstname();
        echo "<br/>";
        echo $datauser->getSurname();
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
        
        //declaration des variables
        $firstname = $request->request->get('firstname');
        $surname = $request->request->get('surname');
        $age = $request->request->get('age');
        $email = $request->request->get('email');
        $mailispublic= $request->request->get('mailispublic');
        $ageispublic = $request->request->get('ageispublic');
        $surnameispublic = $request->request->get('surnameispublic');
        $firstnameispublic = $request->request->get('firstnameispublic');
        
        //appel des tables
        $user = $this ->getUser();
        $repository = $em->getRepository('AppBundle:Datauser')->findOneById_user($user->getId());
        $profil = $em->getRepository('AppBundle:Profil_user')->findOneById_user($user->getId());

        //change les checkbox en booléens
        $ageispublic = !empty($ageispublic) ? true : false ; 
        $surnameispublic = !empty($surnameispublic) ? true : false ; 
        $firstnameispublic = !empty($firstnameispublic) ? true : false ; 
        $mailispublic = !empty($mailispublic) ? true : false ; 
        

        //verifie si les cases sont remplies pour modifier les infos
        if(!empty($firstname))
        {
            $repository->setFirstname($firstname);
        }
        if(!empty($surname))
        {
            $repository->setSurname($surname);
        }
        if(!empty($email))
        {
            $user->setEmail($email);
        }
        if(!empty($age))
        {        
            $repository->setAge($age);
        }

        //remplit la table Profil_user
        $profil->setIdUser($user->getId());
        $profil->setBioIspublic(true);
        $profil->setBio("coucou");
        $profil->setMailIspublic($mailispublic);
        $profil->setAgeIspublic($ageispublic);
        $profil->setSurnameIspublic($surnameispublic);
        $profil->setFirstnameIspublic($firstnameispublic);

        $em->persist($repository);
        $em->flush();

        $em->persist($profil);
        $em->flush();
        return $this->render('default/profil.html.twig', array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
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