<?php

namespace App\Classes;

use DateTime;
use Doctrine\ORM\QueryBuilder;

class MoviesQueryBuilder extends QueryBuilder
{
    const SORT_TYPE_ASC = "ASC";
    const SORT_TYPE_DESC = "DESC";

    public function paginate(int $page = 1, int $perPage = 5): self
    {
        $this->setFirstResult(($page - 1) * $perPage);

        $this->setMaxResults($perPage);

        return $this;
    }

    public function genreId(int $genreId): self
    {
        $this->join($this->getCurrentAlias() . ".genres", "genres")
            ->andWhere($this->expr()->eq("genres.external_id", ":genre_id"))
            ->setParameter("genre_id", $genreId);

        return $this;
    }

    public function setPremierYearStart(DateTime $premierYearStart): self
    {
        $this->andWhere($this->expr()->gte($this->getCurrentAlias() . ".release_date", ":release_date_start"))
            ->setParameter("release_date_start", $premierYearStart);

        return $this;
    }

    public function setPremierYearEnd(DateTime $premierYearEnd): self
    {
        $this->andWhere($this->expr()->lte($this->getCurrentAlias() . ".release_date", ":release_date_end"))
            ->setParameter("release_date_end", $premierYearEnd);

        return $this;
    }

    public function sort(string $sortBy, string $sortType = self::SORT_TYPE_ASC): self
    {
        $this->addOrderBy($this->getCurrentAlias() . "." . $sortBy, $sortType);

        return $this;
    }


    public function nameLike($name)
    {
        $this->andWhere($this->expr()->like($this->getCurrentAlias() . ".title", ":title"))
            ->setParameter("title", '%' . $name . '%');

        return $this;
    }

    protected function getCurrentAlias(): string {
        return current($this->getRootAliases());
    }
}
