<?php
namespace Entities\Concretes;

use Core\Entities\IEntity;
use Entities\Abstracts\BaseEntity;

class User extends BaseEntity implements IEntity{
    public $Name;
    public $Surname;
    public $Email;
    public $Password;
}