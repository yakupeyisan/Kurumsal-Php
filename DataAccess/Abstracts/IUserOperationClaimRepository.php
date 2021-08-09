<?php
namespace DataAccess\Abstracts;

use Core\DataAccess\IRepository;

interface IUserOperationClaimRepository extends IRepository
{
    function IsUnique($filter,$Id=null);
}
