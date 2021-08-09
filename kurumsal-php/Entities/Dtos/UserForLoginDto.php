<?php
namespace Entities\Dtos;

use Core\Entities\IDto;

class UserForLoginDto implements IDto{
    
    public $Email;
    public $Password;
    
}
