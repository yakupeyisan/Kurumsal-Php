<?php

namespace App\Controllers;

use App\Traits\SpecialResponseTrait;
use Business\Abstracts\IOperationClaimService;
use Business\Concretes\OperationClaimManager;
use Business\Constants\PostEntityMapper;
use CodeIgniter\RESTful\ResourceController;
use Core\Utilities\Security\JWTHelper;
use DataAccess\Concretes\OperationClaimRepository;
use Entities\Concretes\OperationClaim;

class OperationClaims extends ResourceController
{
	use SpecialResponseTrait;
	private $data;
	public IOperationClaimService $operationClaimService;
	function __construct()
	{
		$this->data=JWTHelper::encodeAccessToken();
		$this->operationClaimService = new OperationClaimManager(new OperationClaimRepository());
	}
	public function GetAll($page=1)
	{
		if(!in_array('OperationClaim.GetAll',$this->data->claims)){
			return $this->respond($this->error);
		}
		return $this->respond($this->operationClaimService->GetAll(null,$page-1));
	}
	public function GetById(int $id)
	{
		if(!in_array('OperationClaim.Get',$this->data->claims)){
			return $this->respond($this->error);
		}
		return $this->respond($this->operationClaimService->Get(['Id' => $id]));
	}
	public function Get()
	{
		if(!in_array('OperationClaim.Get',$this->data->claims)){
			return $this->respond($this->error);
		}
		$entity = PostEntityMapper::PostMapper($this->request,new OperationClaim());
		$entity = PostEntityMapper::ClearEmpty($entity);
		return $this->respond($this->operationClaimService->Get((array)$entity));
	}
	public function Add()
	{
		if(!in_array('OperationClaim.Add',$this->data->claims)){
			return $this->respond($this->error);
		}
		$user = PostEntityMapper::PostMapper($this->request,new OperationClaim());
		return $this->respond($this->operationClaimService->Add($user,$user->Password));
	}
	public function Update($id = NULL)
	{
		if(!in_array('OperationClaim.Update',$this->data->claims)){
			return $this->respond($this->error);
		}
		$res = $this->operationClaimService->Get(['Id' => $id]);
		$user=PostEntityMapper::PostMapper($this->request,$res->data);
		return $this->respond($this->operationClaimService->Update($user));
	}
	public function Delete($id = NULL)
	{
		if(!in_array('OperationClaim.Delete',$this->data->claims)){
			return $this->respond($this->error);
		}
		$res = $this->operationClaimService->Get(['Id' => $id]);
		$user = $res->data;
		return $this->respond($this->operationClaimService->Delete($user));
	}
}
