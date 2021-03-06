<?php

namespace PortalBundle\Controller;

use PortalBundle\Entity\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Reader controller.
 *
 * @Route("readers")
 */
class ReaderController extends BaseController
{
    /**
     * Lists all reader entities.
     *
     * @Route("/", name="reader_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $readers = $this->getRepo('PortalBundle:Reader')->findAll();

        return $this->render('reader/index.html.twig', array(
            'readers' => $readers,
        ));
    }

    /**
     * Creates a new reader entity.
     *
     * @Route("/new", name="reader_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $reader = new Reader();
        $form = $this->createForm('PortalBundle\Form\ReaderType', $reader);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reader);
            $em->flush($reader);

            return $this->redirectToRoute('reader_show', array('id' => $reader->getId()));
        }

        return $this->render('reader/new.html.twig', array(
            'reader' => $reader,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reader entity.
     *
     * @Route("/{id}", name="reader_show")
     * @Method("GET")
     */
    public function showAction(Reader $reader, $id)
    {
        $reader = $this->getRepo('PortalBundle:Reader')->find($id);
        $books = $this->getRepo('PortalBundle:Reader')->getReaderBooks($id);
        $ratings = $this->getRepo('PortalBundle:Reader')->getReaderRatings($id);
        $reviews = $this->getRepo('PortalBundle:Reader')->getReaderReviews($id);
        $favouriteBooks = $this->getRepo('PortalBundle:FavouriteBook')->showFavouriteBooks($id); 
        $currentBooks = $this->getRepo('PortalBundle:CurrentBook')->showCurrentBooks($id);
        $wantedBooks = $this->getRepo('PortalBundle:WantedBook')->showWantedBooks($id);

        return $this->render('reader/show.html.twig', array(
            'reader' => $reader,
            'books' => $books,
            'ratings' => $ratings,
            'reviews' => $reviews,
            'favouriteBooks' => $favouriteBooks,
            'currentBooks' => $currentBooks,
            'wantedBooks' => $wantedBooks
        ));
    }

    /**
     * Displays a form to edit an existing reader entity.
     *
     * @Route("/{id}/edit", name="reader_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reader $reader)
    {
        $deleteForm = $this->createDeleteForm($reader);
        $editForm = $this->createForm('PortalBundle\Form\ReaderType', $reader);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reader_edit', array('id' => $reader->getId()));
        }

        return $this->render('reader/edit.html.twig', array(
            'reader' => $reader,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reader entity.
     *
     * @Route("/{id}", name="reader_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Reader $reader)
    {
        $form = $this->createDeleteForm($reader);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reader);
            $em->flush($reader);
        }

        return $this->redirectToRoute('reader_index');
    }

    /**
     * Creates a form to delete a reader entity.
     *
     * @param Reader $reader The reader entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reader $reader)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reader_delete', array('id' => $reader->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
