<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 17.04.2018
 * Time: 16:11
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Note;
use AppBundle\Form\NoteType;
use AppBundle\Service\Helper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class NoteController
 * @package AppBundle\Controller
 * @Route("/note")
 */
class NoteController extends Controller
{
    /**
     * @Route("/", name="noteList")
     * @Method({"GET","HEAD","POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        Helper::statGreeting();

        $notes = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findBy([
                'user' => $this->getUser()
            ]);

        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $note->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();
            return $this->redirectToRoute("noteList");
        }

        return $this->render("@App/note/index.html.twig", [
            'notes'=>$notes,
            'formNote' => $form->createView(),
        ]);
    }

}