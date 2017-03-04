<?php

namespace PortalBundle\Controller;

use PortalBundle\Entity\Book;
use PortalBundle\Entity\Rating;
use PortalBundle\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Book controller.
 *
 * @Route("book")
 */
class BookController extends Controller
{
    /**
     * Lists all book entities.
     *
     * @Route("/", name="book_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $books = $em->getRepository('PortalBundle:Book')->findAll();

        return $this->render('book/index.html.twig', array(
            'books' => $books,
        ));
    }

    /**
     * Creates a new book entity.
     *
     * @Route("/new", name="book_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $book = new Book();
        $form = $this->createForm('PortalBundle\Form\BookType', $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush($book);

            return $this->redirectToRoute('book_show', array('id' => $book->getId()));
        }

        return $this->render('book/new.html.twig', array(
            'book' => $book,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a book entity.
     *
     * @Route("/{id}", name="book_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, Book $book)
    {

        $deleteForm = $this->createDeleteForm($book);

        $ratingRepo = $this->getDoctrine()->getManager()->getRepository('PortalBundle:Rating');
        $reviewRepo = $this->getDoctrine()->getManager()->getRepository('PortalBundle:Review');

        $avgRating = $ratingRepo->getAvgRating($book->getId());
        $ratingCount = $ratingRepo->getRatingCount($book->getId()); 
        $bookReviews = $reviewRepo->getBookReviews($book->getId());

        $reviewForm = $this->createForm('PortalBundle\Form\ReviewType');
        $reviewForm->handleRequest($request);
        if ($reviewForm->isSubmitted() && $reviewForm->isValid()) 
        {
            $review = new Review();
            $review->setContents($reviewForm["contents"]->getData());
            //$rating->setReader(1);
            $review->setPublishDate(new \DateTime());            
            $review->setBook($book);
            $em = $this->getDoctrine()->getManager();
            $em->persist($review);
            $em->flush($review);
        }

        $ratingForm = $this->createForm('PortalBundle\Form\RatingType');
        $ratingForm->handleRequest($request);
        if ($ratingForm->isSubmitted() && $ratingForm->isValid()) 
        {
            $rating = new Rating();
            $rating->setRate($ratingForm["rate"]->getData());
            //$rating->setReader(1);
            $rating->setBook($book);
            $em = $this->getDoctrine()->getManager();
            $em->persist($rating);
            $em->flush($rating);
        }

        return $this->render('book/show.html.twig', array(
            'book' => $book,
            'avgRating' => $avgRating,
            'ratingCount' => $ratingCount,
            'bookReviews' => $bookReviews,
            'delete_form' => $deleteForm->createView(),
            'rating_form' => $ratingForm->createView(),
            'review_form' => $reviewForm->createView()
        ));
    }

    /**
     * Displays a form to edit an existing book entity.
     *
     * @Route("/{id}/edit", name="book_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Book $book)
    {
        $deleteForm = $this->createDeleteForm($book);
        $editForm = $this->createForm('PortalBundle\Form\BookType', $book);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('book_show', array('id' => $book->getId()));
        }

        return $this->render('book/edit.html.twig', array(
            'book' => $book,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a book entity.
     *
     * @Route("/{id}", name="book_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Book $book)
    {
        $form = $this->createDeleteForm($book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($book);
            $em->flush($book);
        }

        return $this->redirectToRoute('book_index');
    }

    /**
     * Creates a form to delete a book entity.
     *
     * @param Book $book The book entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Book $book)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('book_delete', array('id' => $book->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
