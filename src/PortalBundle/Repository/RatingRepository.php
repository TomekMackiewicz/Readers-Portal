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

	public function checkReadersUniqueRating($readerId,$bookId) {
		$readersUniqueRating = $this->getEntityManager()->createQuery(
			"SELECT COUNT(r) 
			 FROM PortalBundle:Rating r 
			 WHERE r.reader = $readerId
			 AND r.book = $bookId"
		)->getSingleScalarResult();

		return $readersUniqueRating;		
	}

}
