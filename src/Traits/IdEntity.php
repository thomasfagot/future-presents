<?php

namespace App\Traits;

use Doctrine\ORM\Mapping as ORM;

trait IdEntity
{
    #[ORM\Column('id', type: 'integer', unique: true, nullable: false, options: ['unsigned' => true])]
    #[ORM\Id]
    #[ORM\GeneratedValue('IDENTITY')]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}