<?php 
namespace Business\Concretes;

use Business\Abstracts\IAuthService;
use Business\Abstracts\IUserService;
use Core\Utilities\Results\ErrorDataResult;
use Core\Utilities\Results\ErrorResult;
use Core\Utilities\Results\IDataResult;
use Core\Utilities\Results\IResult;
use Core\Utilities\Results\SuccessDataResult;
use Core\Utilities\Security\JWTHelper;
use Entities\Concretes\User;
use Entities\Dtos\UserForLoginDto;
use Entities\Dtos\UserForRegisterDto;

class AuthManager implements IAuthService
{
    private IUserService $userService;
    function __construct(IUserService $userService){
        $this->userService=$userService;
    }
    function Register(UserForRegisterDto $userForRegisterDto) : IDataResult
    {
        $hash=password_hash(hash('sha512', $userForRegisterDto->Password, true), PASSWORD_DEFAULT);
        $user = new User();
        $user->Name=$userForRegisterDto->Name;
        $user->Surname=$userForRegisterDto->Surname;
        $user->Password=$userForRegisterDto->Password;
        $user->Email=$userForRegisterDto->Email;
        $result=$this->userService->Add($user,$hash);
        if($result->success){
            return new SuccessDataResult($user,"Registration successful.");
        }
        return new ErrorDataResult(null,$result->message);

    }
    function Login(UserForLoginDto $userForLoginDto):IDataResult
    {
        $user=$this->userService->Get(["Email"=>$userForLoginDto->Email])->data;
        if( $user != [])
        {
            if(password_verify(hash('sha512',  $userForLoginDto->Password, true), $user->Password)){
                return new SuccessDataResult($user,"Login successful.");
            }
            return new ErrorDataResult(null,"Wrong email or password.");
        }
        return new ErrorDataResult(null,"Email not found.");
    }
    function UserExists(string $email):IResult{
        return new ErrorResult("Kayıt işlemi başarısız");

    }
    function CreateAccessToken($user):IDataResult{
        $claims = $this->userService->GetClaims($user);
        $accessToken = JWTHelper::createAccessToken($user,$claims->data);
        return new SuccessDataResult($accessToken, "Token is created.");

    }
}
