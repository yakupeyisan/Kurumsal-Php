<?php
namespace DataAccess\Abstracts;

use Core\DataAccess\IRepository;

interface IOperationClaimRepository extends IRepository
{
    function IsUnique($filter,$Id=null);
}
