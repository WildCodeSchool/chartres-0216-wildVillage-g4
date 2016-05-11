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
    
/*********** PROFIL *******************/
    public function showProfilAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this -> getUser();
        $userid = $user -> getId();

        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Datauser');
        $datauser = $repository->findOneById_user($userid);
        $profil = $em->getRepository('AppBundle:Profil_user')->findOneById_user($user->getId());

        return $this->render('default/profil.html.twig', array(
            'user'=>$user,
            'datauser'=>$datauser,
            'profil'=>$profil,
        ));
    }
    
    public function showOtherProfilAction (Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $user = $em->getRepository('AppBundle:User')->findOneById($id);
        $datauser = $em->getRepository('AppBundle:Datauser')->findOneById_user($id);
        $profil = $em->getRepository('AppBundle:Profil_user')->findOneById_user($id);

        return $this->render('default/other_profil.html.twig', array(
            'user'=>$user,
            'datauser'=>$datauser,
            'profil'=>$profil,
        ));
    }
    
    public function modifyProfilAction (Request $request)
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
        $username = $request->request->get('username');
        $bio = $request->request->get('bio');
        
        //appel des tables
        $user = $this ->getUser();
        $repository = $em->getRepository('AppBundle:Datauser')->findOneById_user($user->getId());
        $profil = $em->getRepository('AppBundle:Profil_user')->findOneById_user($user->getId());

        //change les checkbox en booléens
        $firstnameispublic = !empty($firstnameispublic) ? true : false ; 
        $surnameispublic = !empty($surnameispublic) ? true : false ; 
        $mailispublic = !empty($mailispublic) ? true : false ; 
        $ageispublic = !empty($ageispublic) ? true : false ; 

        //verifie si les cases sont remplies pour modifier les infos
        if(!empty($username))
        {
            $user->setUsername($username);
        }
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
        if ($profil==null)
        {
            $profil = new Profil_user();
            $profil -> setBio("");
        }
        if(!empty($bio))
        {
            $profil->setBio($bio);
        }
        //remplit la table Profil_user
        $profil->setIdUser($user->getId());
        $profil->setBioIspublic(true);
        $profil->setMailIspublic($mailispublic);
        $profil->setAgeIspublic($ageispublic);
        $profil->setSurnameIspublic($surnameispublic);
        $profil->setFirstnameIspublic($firstnameispublic);

        $em->persist($repository);
        $em->flush();

        $em->persist($profil);
        $em->flush();
        // return $this->render('default/profil.html.twig', array(
        //     'user'=>$user,
        //     'datauser'=>$repository,
        //     'profil'=>$profil,
        // ));

        $url = $this -> generateUrl('user_profil');
        $response = new RedirectResponse($url);
        return $response;

    }



/*********** POST *******************/

    public function showAllPostsAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        // $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findAll();
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findBy(array(), array('id'=>'desc'));
        $user = $this->getUser();

        if (!empty($posts))
        {
            foreach ($posts as $post)
            {
                $idAuteur = $em -> getRepository('AppBundle:User')->findOneById($post->getIdUser());
                $tab[]= array(
                        'idpost'=>$post->getId(),
                        'iduser'=>$post->getIdUser(),
                        'auteur'=>$idAuteur->getUsername(),
                        'date'=>$post->getDate(),
                        'content'=>$post->getContent(),
                    );
            }
        }
        else
        {
            $tab=1;
        }
        return $this -> render('default/accueil.html.twig', array(
            'user' => $user,
            'posts' => $posts,
            'tabpost'=>$tab,
        ));
    }
    

    public function showPostsAction (Request $request)
    {
        $user = $this -> getUser();
        $userid = $user->getId();
        $username = $user -> getUsername();
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findById_user($userid);
        
        if (!empty($posts))
        {
            foreach ($posts as $post)
            {
                $tab[]= array(
                        'idpost'=>$post->getId(),
                        'date'=>$post->getDate(),
                        'content'=>$post->getContent(),
                    );
            }
        }
        else
        {
            $tab=1;
        }
        return $this->render('default/post.html.twig', array(
			'user'=> $user,
            'post'=>$posts,
            'tabpost'=>$tab,
        ));		
    }
    
    public function sendPostAction (Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this -> getUser();
        $userid = $user->getId();
        $username = $user -> getUsername();
        $posts = $this->getDoctrine()->getRepository('AppBundle:Post')->findById_user($userid);
        $content = $request->request->get('content');

        $post = new Post();
        $post->setIdUser($userid);
        $post->setContent($content);
        $post->setDate(new DateTime());
        $post->setIspublic(1);

		$em->persist($post);
		$em->flush();
		
        $url = $this -> generateUrl('user_posts');
        $response = new RedirectResponse($url);
        return $response;
	}
    
/*********** MESSAGERIE *******************/
	public function showMessagesAction (Request $request)
    {
        $user = $this -> getUser();
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Message');


        $messages_recus = $repository->findByidReceive($user->getId());

        $tab_messages_recus = [];
        foreach ($messages_recus as $message) {

        	$msg_recu = [];
        	
        	$sender = $this->getDoctrine()->getRepository('AppBundle:User')->findOneByid($message->getidSend());
        	
	    	$msg_recu[] = array(
	    		'id' => $message->getId(),
	    		'idsend' => $message->getIdSend(),
	    		'content' => $message->getContent(),
	    		'date' => $message->getDate(),
	    		'sender_username' => $sender->getUsername(),
	    	);

       		array_push($tab_messages_recus, $msg_recu);
       		$message = '';
        }



        $messages_envoyes = $repository->findByidSend($user->getId());

        $tab_messages_envoyes = [];
        foreach ($messages_envoyes as $message) {

        	$msg_envoye = [];
        	
        	$receiver = $this->getDoctrine()->getRepository('AppBundle:User')->findOneByid($message->getIdReceive());
        	
	    	$msg_envoye[] = array(
	    		'id' => $message->getId(),
	    		'idreceive' => $message->getIdReceive(),
	    		'content' => $message->getContent(),
	    		'date' => $message->getDate(),
	    		'receiver_username' => $receiver->getUsername(),
	    	);

       		array_push($tab_messages_envoyes, $msg_envoye);
       		$message ='';

        }        
        // $sent_messages = $repository->findByidSend($user->getId());

        return $this -> render('default/messagerie.html.twig', array(
            'user'             	=> $user,
            'messages_recus'    => $tab_messages_recus,
            'messages_envoyes'  => $tab_messages_envoyes,
        ));
    }

    public function sendMessageAction (Request $request)
    {   
        $em = $this->getDoctrine()->getManager();
        $user = $this -> getUser();
        
        $receive = $request->request->get('receive');
        $content = $request->request->get('content');


        $objReceive = $em->getRepository('AppBundle:User')->findOneByUsername($receive);
        $idReceive = $objReceive->getId();
        // $idreceive = $user ->getId();

        $message = new Message();
        $message->setIdSend($user->getId());
        $message->setIdReceive($idReceive);
        $message->setContent($content);
        $message->setDate(new DateTime());

        
        $em->persist($message);
        $em->flush();
        
        // return $this -> render('default/messagerie_check.html.twig');
        $url = $this -> generateUrl('user_messagerie');
        $response = new RedirectResponse($url);
        return $response;
    }

    public function deleteMessageAction ($id)
    {   
        $em = $this->getDoctrine()->getManager();
        
        $message= $em->getRepository('AppBundle:Message')->findOneById($id);
   
        $em->remove($message);
        $em->flush();
        
        $url = $this -> generateUrl('user_messagerie');
        $response = new RedirectResponse($url);
        return $response;
    }
    
}