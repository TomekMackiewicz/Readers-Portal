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

	public function getRepo($repositoryName) 
	{
		$repository = $this->getDoctrine()->getManager()->getRepository($repositoryName);
		return $repository;
	}	

  public function recentAction()
  {
      $books = $this->getRepo('PortalBundle:Book')->showRecentBooks();

      return $this->render('book/recent.html.twig', array(
          'books' => $books,
      )); 
  }

  public function genresAction()
  {
      $genres = $this->getRepo('PortalBundle:Genre')->findAll();

      return $this->render('genre/all.html.twig', array(
          'genres' => $genres,
      ));
  }

	public function setReview(Request $request, $reviewForm, $checkReadersUniqueReview, $checkReadersUniqueRating, Book $book) 
	{
	    if ($reviewForm->isSubmitted() && $reviewForm->isValid()) 
	    {
	        if ($checkReadersUniqueReview == 0) 
	        {             
	            $review = new Review();
	            $review->setContents($reviewForm["contents"]->getData());
	            $review->setReader($this->getUser());
	            $review->setPublishDate(new \DateTime());            
	            $review->setBook($book);	            

	            if($checkReadersUniqueRating == 0 && $reviewForm["rate"]->getData() !== null) {
		            	$review->setRate($reviewForm["rate"]->getData());
			            $rating = new Rating();                
			            $rating->setRate($reviewForm["rate"]->getData());
			            $rating->setReader($this->getUser());
			            $rating->setBook($book);	            	
	            } else if($reviewForm["rate"]->getData() !== null) {
	            	$reviewForm->addError(new FormError('You already rated this book!'));
	            }

	            $em = $this->getDoctrine()->getManager();
	            $em->persist($review);

	            if($reviewForm["rate"]->getData() !== null && $checkReadersUniqueRating == 0) {
	            		$em->persist($rating);
	          	}

	            $em->flush();

	            return $this->redirectToRoute('book_show', array('id' => $book->getId()));

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

              return $this->redirectToRoute('book_show', array('id' => $book->getId()));

          } else {
              $ratingForm->addError(new FormError('You already rated this book!'));
          }                
      } 		
	}


}