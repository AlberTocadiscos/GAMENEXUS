<?php

namespace App\Repository;

use App\Entity\WishlistGames;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<WishlistGames>
 *
 * @method WishlistGames|null find($id, $lockMode = null, $lockVersion = null)
 * @method WishlistGames|null findOneBy(array $criteria, array $orderBy = null)
 * @method WishlistGames[]    findAll()
 * @method WishlistGames[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WishlistGamesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WishlistGames::class);
    }

    public function add(WishlistGames $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(WishlistGames $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findGameByUser($id_game, $id_platform, $id_wishlist)
    {

        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT w FROM App\Entity\WishlistGames w
             WHERE w.idGame = :game
             AND w.idPlatform = :platform
             AND w.idWishlist = :wishlist'
        )->setParameter('game', $id_game)
        ->setParameter('platform', $id_platform)
        ->setParameter('wishlist', $id_wishlist);

        return $sql->getOneOrNullResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function findByGamesWishlist($value): array
    {

        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT w FROM App\Entity\WishlistGames w
            JOIN App\Entity\GamesPlatform g
            WHERE w.idPlatform = g.idPlatform
            AND w.idGame = g.game
            AND w.idWishlist = :wishlist
            GROUP BY w.idGame'
        )->setParameter('wishlist', $value);

        return $sql->getResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }


//    /**
//     * @return WishlistGames[] Returns an array of WishlistGames objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?WishlistGames
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
