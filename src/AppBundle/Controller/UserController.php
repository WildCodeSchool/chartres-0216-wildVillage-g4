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
        var_dump($user);
        return $this->render('default/profil.html.twig', array('base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }
}