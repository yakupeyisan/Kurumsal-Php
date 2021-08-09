<?php 
namespace Business\Validations;

use Business\Validations\Abstracts\Validation;
use DataAccess\Abstracts\IUserOperationClaimRepository;
use Entities\Concretes\UserOperationClaim;

class UserOperationClaimValidation extends Validation
{
    public IUserOperationClaimRepository $userUserOperationClaimRepository;
    function __construct(IUserOperationClaimRepository $userUserOperationClaimRepository)
    {
        $this->userUserOperationClaimRepository=$userUserOperationClaimRepository;
        parent::__construct($this);
    }
    public function CheckName():bool
    {
        if($this->entity->Name!=null){
            return true;
        }
        $this->errors="Name is required";
        return false;

    }

}
