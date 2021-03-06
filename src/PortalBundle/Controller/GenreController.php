<?php

namespace PortalBundle\Controller;

use PortalBundle\Entity\Genre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Genre controller.
 *
 * @Route("genres")
 */
class GenreController extends BaseController
{
    /**
     * @Route("/", name="genre_index")
     */
    public function indexAction()
    {
        $genres = $this->getRepo('PortalBundle:Genre')->findAll();

        return $this->render('genre/index.html.twig', array(
            'genres' => $genres,
        ));        
    }

    /**
     * Creates a new genre entity.
     *
     * @Route("/new", name="genre_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $genre = new Genre();
        $form = $this->createForm('PortalBundle\Form\GenreType', $genre);
        $form->handleRequest($request);     

        if ($form->isSubmitted() && $form->isValid()) {        
            $this->getDoctrine()->getManager()->persist($genre);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('genre_show', array('id' => $genre->getId()));
        }

        return $this->render('genre/new.html.twig', array(
            'genre' => $genre,
            'form' => $form->createView(),
        ));
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
        $recentBooks = $this->getRepo('PortalBundle:Genre')->showRecentBooks($genre->getId()); 
        $topBooks = $this->getRepo('PortalBundle:Genre')->showTopRatedBooks($genre->getId());
        $popularBooks = $this->getRepo('PortalBundle:Genre')->showPopularBooks($genre->getId());

        return $this->render('genre/show.html.twig', array(
            'genre' => $genre,
            'recentBooks' => $recentBooks,
            'topBooks' => $topBooks,
            'popularBooks' => $popularBooks
            //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing genre entity.
     *
     * @Route("/{id}/edit", name="genre_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Genre $genre)
    {
        $deleteForm = $this->createDeleteForm($genre);
        $editForm = $this->createForm('PortalBundle\Form\GenreType', $genre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('genre_show', array('id' => $genre->getId()));
        }

        return $this->render('genre/edit.html.twig', array(
            'genre' => $genre,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a genre entity.
     *
     * @Route("/{id}", name="genre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Genre $genre)
    {
        $form = $this->createDeleteForm($genre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($genre);
            $em->flush($genre);
        }

        return $this->redirectToRoute('genre_index');
    }

    /**
     * Creates a form to delete a genre entity.
     *
     * @param Author $genre The genre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Genre $genre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('genre_delete', array('id' => $genre->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

}