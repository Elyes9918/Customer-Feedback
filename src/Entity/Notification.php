<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use App\Trait\DateTrait;
use App\Trait\TokenTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{

    use DateTrait;
    use TokenTrait;

     //Type Constants
     const TYPE_USER = 0;
     const TYPE_PROJECT = 1;
     const TYPE_FEEDBACK =2;
     const TYPE_COMMENT = 3;

    // isRead 
    const ISREAD_TRUE=1;
    const ISREAD_FALSE=0;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $isRead = null;

    #[ORM\Column(nullable: true)]
    private ?int $type = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsRead(): ?int
    {
        return $this->isRead;
    }

    public function setIsRead(int $isRead): self
    {
        $this->isRead = $isRead;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
