<?php

namespace App\Repository;

use App\Entity\Platforms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Platforms>
 *
 * @method Platforms|null find($id, $lockMode = null, $lockVersion = null)
 * @method Platforms|null findOneBy(array $criteria, array $orderBy = null)
 * @method Platforms[]    findAll()
 * @method Platforms[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatformsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Platforms::class);
    }

    public function add(Platforms $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Platforms $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByName($name)
    {
        $em = $this->getEntityManager();

        $sql =  $em->createQuery(
            'SELECT p FROM App\Entity\Platforms p
             WHERE p.platformName = :value'
        )->setParameter('value', $name);

        return $sql->getSingleResult(\Doctrine\ORM\Query::HYDRATE_OBJECT);
    }

    public function findPlatformArrayId($name, $platform)
    {
        $em = $this->getEntityManager();
        $first = 0;

        $sql = $em->createQueryBuilder()
        ->select('p.idPlatform')
        ->from(Platforms::class, 'p');

        // If platform array is not empty, we add the where statement with the content of that array
        if(count(array_filter($name)) != 0){
            $sql->where('p.platformName in (:name)')
            ->setParameter('name', $name,\Doctrine\DBAL\Connection::PARAM_STR_ARRAY );
            $first = 1;
        }

        // Where statements for pc games, all and offers
        if($platform == 'pc'){
            $query = "p.platformName NOT IN ('playstation', 'xbox', 'switch')";
            $first == 1 ? $sql -> andWhere($query) : $sql->where($query);
        }elseif($platform != 'all' && $platform != 'ofertas'){
            $query = 'p.platformName = :platform';
            $first == 1 ? $sql -> andWhere($query) : $sql->where($query);
            $sql->setParameter('platform', $platform);
        }

        return $sql->getQuery()->getArrayResult();
    }
    
}
