<?php 

namespace App\DataTransferObjects;

class RefreshTokenDto {

    private ?string $id=null;
    private ?string $refreshToken=null;
    private ?string $username=null;
    private ?String $valid=null;



   

    /**
     * Get the value of id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of refreshToken
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    /**
     * Set the value of refreshToken
     */
    public function setRefreshToken(?string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     */
    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of valid
     */
    public function getValid(): ?String
    {
        return $this->valid;
    }

    /**
     * Set the value of valid
     */
    public function setValid(?String $valid): self
    {
        $this->valid = $valid;

        return $this;
    }
}