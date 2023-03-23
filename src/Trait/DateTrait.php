<?php 

namespace App\Trait;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;



trait DateTrait
{

    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'],nullable: true)]
    private $created_at;

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private $modified_at;

    public function getModifiedAt(): ?\DateTimeInterface
    {
        if($this->modified_at==null){
            return new DateTimeImmutable('0001-01-01');
        }

        return $this->modified_at;
    }

    public function setModifiedAt(\DateTimeInterface $modified_at): self
    {
        $this->modified_at = $modified_at;

        return $this;
    }


    
    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->created_at = new \DateTimeImmutable();
        $this->modified_at = new DateTime();
      
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
            $this->modified_at = new DateTime();
    
    }



}