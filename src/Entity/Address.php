<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Address
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 * @ORM\Table(name="app__address")
 */
class Address
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\SequenceGenerator(sequenceName="public.app__address_id_seq", allocationSize=1,initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    private $content;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Address
     */
    public function setContent(string $content): Address
    {
        $this->content = $content;
        return $this;
    }
}