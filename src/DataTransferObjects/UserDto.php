<?php 

namespace App\DataTransferObjects;

use DateTime;

class UserDto{

    private ?int $id = null;
    private ?string $email=null;
    private ?DateTime $created_at=null;
    private ?DateTime $modified_at=null;
    private ?string $first_name=null;
    private ?string $last_name=null;
    private ?string $birth_date=null;
    private ?string $status=null;
    private ?string $address=null;
    private ?string $phone_number=null;
    private ?string $company=null;
    private array $projects_id= [];
    private array $feedbacks_id= [];
    private array $roles= [];

    

}
