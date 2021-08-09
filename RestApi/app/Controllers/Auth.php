<?php

namespace App\Controllers;

use Business\Abstracts\IAuthService;
use Business\Abstracts\IUserService;
use Business\Concretes\AuthManager;
use Business\Concretes\UserManager;
use Business\Constants\PostEntityMapper;
use CodeIgniter\RESTful\ResourceController;
use Core\Utilities\Security\JWTHelper;
use DataAccess\Concretes\UserRepository;
use Entities\Concretes\User;
use Entities\Dtos\UserForLoginDto;
use Entities\Dtos\UserForRegisterDto;
use Firebase\JWT\JWT;

class Auth extends ResourceController
{
	private $error=[
		"status"=>false,
		"message"=>"Permission not found",
	];
	public IAuthService $authService;
	function __construct()
	{
		$this->authService = new AuthManager(new UserManager(new UserRepository()));
	}
	public function Register()
	{
		$userForRegister = PostEntityMapper::PostMapperDto($this->request,new UserForRegisterDto());
		return $this->respond($this->authService->Register($userForRegister));
	}
	public function Login()
	{
		$loginData = PostEntityMapper::PostMapperDto($this->request,new UserForLoginDto());
		$userToLogin= $this->authService->Login($loginData);
		if(!$userToLogin->success){
			return $this->respond($userToLogin);
		}
		$token=$this->authService->CreateAccessToken($userToLogin->data);
		$token->message="Login successful";
		return $this->respond($token);
	}
}
