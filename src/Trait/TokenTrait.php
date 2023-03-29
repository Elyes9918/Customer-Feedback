<?php 

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;

trait TokenTrait
{
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $token_id = null;

    public function getTokenId(): ?string
    {
        return $this->token_id;
    }

    public function setTokenId(?string $token_id): self
    {
        $this->token_id = $token_id;

        return $this;
    }

}