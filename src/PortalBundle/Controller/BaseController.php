<?php

namespace PortalBundle\Controller;

use PortalBundle\Entity\Book;
use PortalBundle\Entity\Reader;
use PortalBundle\Entity\Rating;
use PortalBundle\Entity\Review;
use Symfony\Component\Form\FormError;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{

  public function recentAction()
  {
      $books = $this
          ->getDoctrine()
          ->getManager()
          ->getRepository('PortalBundle:Book')->findBy(array(), array('publishDate' => 'DESC'));

      return $this->render('book/recent.html.twig', array(
          'books' => $books,
      ));
  }

	public function getRatingRepo() 
	{
		$ratingRepo = $this->getDoctrine()->getManager()->getRepository('PortalBundle:Rating');
		return $ratingRepo;
	}

	public function getReviewRepo() 
	{
		$reviewRepo = $this->getDoctrine()->getManager()->getRepository('PortalBundle:Review');
		return $reviewRepo;
	}

	public function setReview(Request $request, $reviewForm, $checkReadersUniqueReview, $checkReadersUniqueRating, Book $book) 
	{
		$reader = $this->getUser();

	    if ($reviewForm->isSubmitted() && $reviewForm->isValid()) 
	    {
	        if ($checkReadersUniqueReview == 0) 
	        {             
	            $review = new Review();
	            $review->setContents($reviewForm["contents"]->getData());
	            if($checkReadersUniqueRating == 0) {
	            	$review->setRate($reviewForm["rate"]->getData());
	            } else {
	            	$reviewForm->addError(new FormError('You already voted on this book!'));
	            }
	            
	            $review->setReader($reader);
	            $review->setPublishDate(new \DateTime());            
	            $review->setBook($book);

	            if ($checkReadersUniqueRating == 0)
	            {
			            $rating = new Rating();                
			            $rating->setRate($reviewForm["rate"]->getData());
			            $rating->setReader($reader);
			            $rating->setBook($book);
	            } 

	            $em = $this->getDoctrine()->getManager();
	            $em->persist($review);

	            if($reviewForm["rate"]->getData() !== null && $checkReadersUniqueRating == 0) {
	            		$em->persist($rating);
	          	}

	            $em->flush();

	            return $this->redirect($request->getUri());

	        } else {
	            $reviewForm->addError(new FormError('You already posted a review!'));
	        }                     
	    }
	}

	public function setRating(Request $request, $ratingForm, $checkReadersUniqueRating, Book $book)
	{

      if ($ratingForm->isSubmitted() && $ratingForm->isValid()) 
      {
          if ($checkReadersUniqueRating == 0) 
          {
              $rating = new Rating();
              $rating->setRate($ratingForm["rate"]->getData());
              $rating->setReader($this->getUser());
              $rating->setBook($book);
              $em = $this->getDoctrine()->getManager();
              $em->persist($rating);
              $em->flush($rating);

              //return $this->redirect($request->getUri());
              return $this->redirectToRoute('book_show', array('id' => $book->getId()));

          } else {
              $ratingForm->addError(new FormError('You already voted on this book!'));
          }                
      } 		
	}


}