<?php
namespace Entities\Dtos;

use Core\Entities\IDto;

class UserForRegisterDto implements IDto{
    
    public $Name;
    public $Surname;
    public $Email;
    public $Password;
    
}
