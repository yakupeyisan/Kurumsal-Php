<?php 
namespace Business\Abstracts;

use Core\Utilities\Results\IDataResult;
use Core\Utilities\Results\IResult;

interface IOperationClaimService
{
    function GetAll($filter=null,int $page=0):IDataResult;
    function Get($filter):IDataResult;
    function Add($entity):IResult;
    function Update($entity):IResult;
    function Delete($entity):IResult;
}
