<?php

namespace App\Controllers;

use App\Traits\SpecialResponseTrait;
use Business\Abstracts\IUserService;
use Business\Concretes\UserManager;
use Business\Constants\PostEntityMapper;
use CodeIgniter\RESTful\ResourceController;
use Core\Utilities\Security\JWTHelper;
use DataAccess\Concretes\UserRepository;
use Entities\Concretes\User;
use Firebase\JWT\JWT;

class Users extends ResourceController
{
	use SpecialResponseTrait;
	private $data;
	public IUserService $userService;
	function __construct()
	{
		$this->data=JWTHelper::encodeAccessToken();
		$this->userService = new UserManager(new UserRepository());
	}
	public function GetAll($page=1)
	{
		if(!in_array('User.GetAll',$this->data->claims)){
			return $this->respond($this->error);
		}
		return $this->respond($this->userService->GetAll(null,$page-1));
	}
	public function GetById(int $id)
	{
		if(!in_array('User.Get',$this->data->claims)){
			return $this->respond($this->error);
		}
		return $this->respond($this->userService->Get(['Id' => $id]));
	}
	public function Get()
	{
		if(!in_array('User.Get',$this->data->claims)){
			return $this->respond($this->error);
		}
		$user = PostEntityMapper::PostMapper($this->request,new User());
		$user = PostEntityMapper::ClearEmpty($user);
		return $this->respond($this->userService->Get((array)$user));
	}
	public function Add()
	{
		if(!in_array('User.Add',$this->data->claims)){
			return $this->respond($this->error);
		}
		$user = PostEntityMapper::PostMapper($this->request,new User());
		return $this->respond($this->userService->AddUser($user,$user->Password));
	}
	public function Update($id = NULL)
	{
		if(!in_array('User.Update',$this->data->claims)){
			return $this->respond($this->error);
		}
		$res = $this->userService->Get(['Id' => $id]);
		$user=PostEntityMapper::PostMapper($this->request,$res->data);
		return $this->respond($this->userService->Update($user));
	}
	public function Delete($id = NULL)
	{
		if(!in_array('User.Delete',$this->data->claims)){
			return $this->respond($this->error);
		}
		$res = $this->userService->Get(['Id' => $id]);
		$user = $res->data;
		return $this->respond($this->userService->Delete($user));
	}
}
