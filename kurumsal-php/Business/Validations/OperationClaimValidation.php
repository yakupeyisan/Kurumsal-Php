<?php 
namespace Business\Validations;

use Business\Validations\Abstracts\Validation;
use DataAccess\Abstracts\IOperationClaimRepository;
use Entities\Concretes\OperationClaim;

class OperationClaimValidation extends Validation
{
    public IOperationClaimRepository $operationClaimRepository;
    function __construct(IOperationClaimRepository $operationClaimRepository)
    {
        $this->operationClaimRepository=$operationClaimRepository;
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
