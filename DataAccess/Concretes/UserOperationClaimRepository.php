<?php
namespace DataAccess\Concretes;

use Core\DataAccess\SignedSoftwareFramework\RepositoryBase;
use DataAccess\Abstracts\IUserOperationClaimRepository;
use Entities\Concretes\UserOperationClaim;

class UserOperationClaimRepository extends RepositoryBase implements IUserOperationClaimRepository
{
    function __construct()
    {
        parent::__construct("UserOperationClaims",get_class(new UserOperationClaim()));
    }
    public function IsUnique($filter,$Id=null): bool
    {
        $builder = $this->db->table($this->table);
        $builder->where($filter);
        $builder->where("Id !=",$Id);
        return count($builder->get()->getResult()) == 0;
    }

}
