<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;

/**
 * @Entity(repositoryClass="App\Repositories\MovieRepository") @Table(name="movies")
 */
class Movie
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     */
    protected $id;

    /**
     * @Column(type="integer", unique=true) @UniqueConstraint
     */
    protected $external_id;

    /**
     * @Column(type="string")
     */
    protected $title;

    /**
     * @Column(type="float")
     */
    protected $popularity;

    /**
     * @Column(type="date")
     */
    protected $release_date;

    /**
     * @Column(type="integer")
     */
    protected $vote_count;

    /**
     * @Column(type="float")
     */
    protected $vote_average;

    /**
     * @ManyToMany(targetEntity="Genre")
     * @JoinTable(name="movie_to_genre",
     *      joinColumns={@JoinColumn(name="movie_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="genre_id", referencedColumnName="id")}
     *      )
     */
    protected $genres;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
    }

    public function getId(){
        return $this->id;
    }

    public function setExternalId($id)
    {
        $this->external_id = $id;
    }

    public function getExternalId()
    {
        return $this->external_id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;
    }

    public function getPopularity()
    {
        return $this->popularity;
    }

    public function setReleaseDate($release_date)
    {
        $this->release_date = $release_date;
    }

    public function getReleaseDate()
    {
        return $this->release_date;
    }

    public function setVoteCount($vote_count)
    {
        $this->vote_count = $vote_count;
    }

    public function getVoteCount()
    {
        return $this->vote_count;
    }

    public function setVoteAverage($vote_average)
    {
        $this->vote_average = $vote_average;
    }

    public function getVoteAverage()
    {
        return $this->vote_average;
    }

    public function setGenres($genres){
        $this->genres = $genres;
    }

    public function getGenres(){
        return $this->genres;
    }
}
