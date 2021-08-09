<?php
namespace DataAccess\Abstracts;

use Core\DataAccess\IRepository;

interface IUserRepository extends IRepository
{
    function IsUnique($filter,$Id=null);
    function GetClaims($entity);
}
