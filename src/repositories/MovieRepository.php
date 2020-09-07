<?php

namespace App\Repositories;

use App\Classes\MoviesQueryBuilder;
use Doctrine\ORM\EntityRepository;

class MovieRepository extends EntityRepository
{

    public function createQueryBuilder($alias, $indexBy = null): MoviesQueryBuilder
    {
        return (new MoviesQueryBuilder($this->_em))
            ->select($alias)
            ->from($this->_entityName, $alias, $indexBy);
    }
}
