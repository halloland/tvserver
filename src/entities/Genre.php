<?php

namespace App\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;

/**
 * @Entity @Table(name="genres")
 */
class Genre
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
    protected $name;

    public function getId(){
        return $this->id;
    }

    public function setExternalId($id){
        $this->external_id = $id;
    }

    public function getExternalId(){
        return $this->external_id;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }
}
