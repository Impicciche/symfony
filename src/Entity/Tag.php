<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */

class Tag
{
    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="guid")
     * @ORM\GeneratedValue(strategy="UUID")
     */

    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $label;

    /**
     * @return mixed
     */
    public function getId() : ?string
    {
        return $this->id;
    }



    /**
     * @return mixed
     */
    public function getLabel() : ?string
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     * @return Tag
     */
    public function setLabel($label) : Tag
    {
        $this->label = $label;
        return $this;
    }





}