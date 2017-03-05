<?php

namespace PortalBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * RatingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RatingRepository extends EntityRepository
{

	public function getAvgRating($bookId) {
		$avgRating = $this->getEntityManager()->createQuery(
			"SELECT AVG(r.rate) 
			 FROM PortalBundle:Rating r 
			 WHERE r.book = '$bookId'" 
		)->getSingleScalarResult();

		return $avgRating;
	}

	public function getRatingCount($bookId) {
		$ratingCount = $this->getEntityManager()->createQuery(
			"SELECT COUNT(r) 
			 FROM PortalBundle:Rating r 
			 WHERE r.book = '$bookId'" 
		)->getSingleScalarResult();

		return $ratingCount;
	}

	public function checkReadersUniqueRating($readerId,$bookId) {
		$readersUniqueRating = $this->getEntityManager()->createQuery(
			"SELECT COUNT(r) 
			 FROM PortalBundle:Rating r 
			 WHERE r.reader = $readerId
			 AND r.book = $bookId"
		)->getSingleScalarResult();

		return $readersUniqueRating;		
	}

	public function getReaderCountOnBook($readerId,$bookId) {
		$readerCountOnBook = $this->getEntityManager()->createQuery(
			"SELECT r.rate
			 FROM PortalBundle:Rating r 
			 WHERE r.reader = $readerId
			 AND r.book = $bookId"
		)->getSingleScalarResult();
		
		return $readerCountOnBook;		
	}

}
