<?php

namespace Business\Concretes;

use Business\Abstracts\IUserOperationClaimService;
use Business\Validations\UserOperationClaimValidation;
use Core\Business\BaseManager;
use DataAccess\Abstracts\IUserOperationClaimRepository;

class UserOperationClaimManager extends BaseManager implements IUserOperationClaimService
{
    public function __construct(IUserOperationClaimRepository $repository)
    {
        $this->repository = $repository;
        $this->validation= new UserOperationClaimValidation($repository);
    }
}
