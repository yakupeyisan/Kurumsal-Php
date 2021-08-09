<?php
namespace Business\Abstracts;

use Core\Utilities\Results\IDataResult;
use Core\Utilities\Results\IResult;
use Entities\Dtos\UserForLoginDto;
use Entities\Dtos\UserForRegisterDto;

interface IAuthService
{
    function Register(UserForRegisterDto $userForRegisterDto):IDataResult;
    function Login(UserForLoginDto $userForLoginDto):IDataResult;
    function UserExists(string $email):IResult;
    function CreateAccessToken($user):IDataResult;
}
