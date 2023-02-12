<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, User::class);
	}

	public function getUsedTagsForPseudo(string $pseudo): array
	{
		$queryBuilder = $this->createQueryBuilder('user');

		$queryBuilder
			->select('user.tag')
			->where('user.pseudo = :pseudo')
			->setParameter('pseudo', $pseudo)
		;

		return $queryBuilder->getQuery()->getSingleColumnResult();
	}
}
