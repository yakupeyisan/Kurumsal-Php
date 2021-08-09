<?php
namespace Entities\Concretes;

use Core\Entities\IEntity;
use Entities\Abstracts\BaseEntity;

class UserOperationClaim extends BaseEntity implements IEntity{
    public $UserId;
    public $OperationClaimId;
}