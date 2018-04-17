<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homePage")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        if ($this->getUser()){
            return $this->redirectToRoute("noteList");
        }
        return $this->render("@App/home/index.html.twig", array(
            'user' => $this->getUser()
        ));
    }
    /**
     * @Route("/login",name="loginPage")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        if ($this->getUser()){
            return $this->redirectToRoute("noteList");
        }
        $authUtils = $this->get('security.authentication_utils');
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('@App/home/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

}
