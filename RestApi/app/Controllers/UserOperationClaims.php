<?php

namespace App\Controllers;

use App\Traits\SpecialResponseTrait;
use Business\Abstracts\IUserOperationClaimService;
use Business\Concretes\UserOperationClaimManager;
use Business\Constants\PostEntityMapper;
use CodeIgniter\RESTful\ResourceController;
use Core\Utilities\Security\JWTHelper;
use DataAccess\Concretes\UserOperationClaimRepository;
use Entities\Concretes\UserOperationClaim;

class UserOperationClaims extends ResourceController
{
	use SpecialResponseTrait;
	private $data;
	public IUserOperationClaimService $userOperationClaimService;
	function __construct()
	{
		$this->data=JWTHelper::encodeAccessToken();
		$this->userOperationClaimService = new UserOperationClaimManager(new UserOperationClaimRepository());
	}
	public function GetAll($page=1)
	{
		if(!in_array('UserOperationClaim.GetAll',$this->data->claims)){
			return $this->respond($this->error);
		}
		return $this->respond($this->userOperationClaimService->GetAll(null,$page-1));
	}
	public function GetById(int $id)
	{
		if(!in_array('UserOperationClaim.Get',$this->data->claims)){
			return $this->respond($this->error);
		}
		return $this->respond($this->userOperationClaimService->Get(['Id' => $id]));
	}
	public function Get()
	{
		if(!in_array('UserOperationClaim.Get',$this->data->claims)){
			return $this->respond($this->error);
		}
		$entity = PostEntityMapper::PostMapper($this->request,new UserOperationClaim());
		$entity = PostEntityMapper::ClearEmpty($entity);
		return $this->respond($this->userOperationClaimService->Get((array)$entity));
	}
	public function Add()
	{
		if(!in_array('UserOperationClaim.Add',$this->data->claims)){
			return $this->respond($this->error);
		}
		$user = PostEntityMapper::PostMapper($this->request,new UserOperationClaim());
		return $this->respond($this->userOperationClaimService->Add($user,$user->Password));
	}
	public function Update($id = NULL)
	{
		if(!in_array('UserOperationClaim.Update',$this->data->claims)){
			return $this->respond($this->error);
		}
		$res = $this->userOperationClaimService->Get(['Id' => $id]);
		$user=PostEntityMapper::PostMapper($this->request,$res->data);
		return $this->respond($this->userOperationClaimService->Update($user));
	}
	public function Delete($id = NULL)
	{
		if(!in_array('UserOperationClaim.Delete',$this->data->claims)){
			return $this->respond($this->error);
		}
		$res = $this->userOperationClaimService->Get(['Id' => $id]);
		$user = $res->data;
		return $this->respond($this->userOperationClaimService->Delete($user));
	}
}
