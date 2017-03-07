<?php

namespace PortalBundle\Controller;

use PortalBundle\Entity\Book;
use PortalBundle\Entity\Rating;
use PortalBundle\Entity\Review;
use Symfony\Component\Form\FormError;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Book controller.
 *
 * @Route("book")
 */
class BookController extends BaseController
{

    /**
     * Lists all book entities.
     *
     * @Route("/", name="book_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $books = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('PortalBundle:Book')->findBy(array(), array('publishDate' => 'DESC'));

        return $this->render('book/index.html.twig', array(
            'books' => $books,
        ));
    }

    /**
     * @Route("/search", name="book_search")
     * @Method("GET")
     */
    public function searchAction(Request $request)
    {
        $source = array();
        $term = trim(strip_tags($request->get('term')));

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('PortalBundle:Book')->createQueryBuilder('b')
            ->where('b.title LIKE :title')
            ->setParameter('title', '%'.$term.'%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        foreach ($entities as $entity)
        {
            $source[] = ['value' => $entity->getId(), 'label' => $entity->getTitle()];
        }

        $response = new JsonResponse();
        $response->setData($source);

        return $response;
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
            $this->getDoctrine()->getManager()->persist($book);
            $this->getDoctrine()->getManager()->flush($book);

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
        $readForm = $this->createReadForm($book);
        $reader = $this->getUser();
        $reviewForm = $this->createForm('PortalBundle\Form\ReviewType')->handleRequest($request);
        $ratingForm = $this->createForm('PortalBundle\Form\RatingType')->handleRequest($request);

        $checkReadersUniqueRating = $this->getRatingRepo()
            ->checkReadersUniqueRating($reader->getId(),$book->getId());

        $checkReadersUniqueReview = $this->getReviewRepo()
            ->checkReadersUniqueReview($reader->getId(),$book->getId());

        $this->setReview($request, $reviewForm, $checkReadersUniqueReview, $checkReadersUniqueRating, $book);
        $this->setRating($request, $ratingForm, $checkReadersUniqueRating, $book);

        return $this->render('book/show.html.twig', array(
            'book' => $book,
            'delete_form' => $deleteForm->createView(),
            'rating_form' => $ratingForm->createView(),
            'review_form' => $reviewForm->createView(),
            'read_form' => $readForm->createView(),
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
            $this->getDoctrine()->getManager()->remove($book);
            $this->getDoctrine()->getManager()->flush($book);
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
            ->getForm();
    }

    /**
     * Marks book as read.
     *
     * @Route("/{id}/read", name="book_read")
     * @Method("POST")
     */
    public function readAction(Request $request, Book $book)
    {
        $form = $this->createReadForm($book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reader = $this->getUser();
            $book->addReader($reader);
            $reader->addBook($book);
            $this->getDoctrine()->getManager()->persist($book);
            $this->getDoctrine()->getManager()->persist($reader);
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Book marked as read!');

        }

        return $this->redirectToRoute('book_show', array('id' => $book->getId()));
    }    

    /**
     * Creates a form to mark book as read.
     *
     * @param Book $book The book entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createReadForm(Book $book)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('book_read', array('id' => $book->getId())))
            ->setMethod('POST')
            ->getForm();
    }

////////////////////////////

    // /**
    //  * Add book to favourites.
    //  *
    //  * @Route("/{id}/favourite", name="book_favourite")
    //  * @Method("POST")
    //  */
    // public function favouriteAction(Request $request, Book $book)
    // {
    //     $form = $this->createFavouriteForm($book);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $reader = $this->getUser();
    //         $book->addReader($reader);
    //         $reader->addBook($book);
    //         $this->getDoctrine()->getManager()->persist($book);
    //         $this->getDoctrine()->getManager()->persist($reader);
    //         $this->getDoctrine()->getManager()->flush();

    //         $request->getSession()
    //             ->getFlashBag()
    //             ->add('success', 'Book marked as read!');

    //     }

    //     return $this->redirectToRoute('book_show', array('id' => $book->getId()));
    // }    

    // /**
    //  * Creates a form to mark book as read.
    //  *
    //  * @param Book $book The book entity
    //  *
    //  * @return \Symfony\Component\Form\Form The form
    //  */
    // private function createReadForm(Book $book)
    // {
    //     return $this->createFormBuilder()
    //         ->setAction($this->generateUrl('book_read', array('id' => $book->getId())))
    //         ->setMethod('POST')
    //         ->getForm();
    // }

}
