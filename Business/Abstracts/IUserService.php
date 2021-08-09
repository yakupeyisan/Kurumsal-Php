<?php 
namespace Business\Abstracts;

use Core\Utilities\Results\IDataResult;
use Core\Utilities\Results\IResult;

interface IUserService
{
    function GetClaims($entity):IDataResult;
    function GetAll($filter=null,int $page=0):IDataResult;
    function Get($filter):IDataResult;
    function AddUser($entity,$password):IResult;
    function Update($entity):IResult;
    function Delete($entity):IResult;
}
