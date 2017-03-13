<?php

namespace PortalBundle\Controller;

use PortalBundle\Entity\Genre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Genre controller.
 *
 * @Route("genres")
 */
class GenreController extends Controller
{
    /**
     * @Route("/", name="genre_index")
     */
    public function indexAction()
    {
        return $this->render('genre/index.html.twig');
    }

    /**
     * Finds and displays a genre entity.
     *
     * @Route("/{id}", name="genre_show")
     * @Method("GET")
     */
    public function showAction(Genre $genre)
    {
        //$deleteForm = $this->createDeleteForm($genre);

        return $this->render('genre/show.html.twig', array(
            'genre' => $genre,
            //'delete_form' => $deleteForm->createView(),
        ));
    }

}