<?php

namespace Business\Concretes;

use Business\Abstracts\IOperationClaimService;
use Business\Validations\OperationClaimValidation;
use Core\Business\BaseManager;
use DataAccess\Abstracts\IOperationClaimRepository;

class OperationClaimManager extends BaseManager implements IOperationClaimService
{
    public function __construct(IOperationClaimRepository $operationClaimRepository)
    {
        $this->repository = $operationClaimRepository;
        $this->validation= new OperationClaimValidation($operationClaimRepository);
    }
}
