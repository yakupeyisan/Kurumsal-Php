<?php
namespace DataAccess\Concretes;

use Core\DataAccess\SignedSoftwareFramework\RepositoryBase;
use DataAccess\Abstracts\IOperationClaimRepository;
use Entities\Concretes\OperationClaim;
class OperationClaimRepository extends RepositoryBase implements IOperationClaimRepository
{
    function __construct()
    {
        parent::__construct("OperationClaims",get_class(new OperationClaim()));
    }
    public function IsUnique($filter,$Id=null): bool
    {
        $builder = $this->db->table($this->table);
        $builder->where($filter);
        $builder->where("Id !=",$Id);
        return count($builder->get()->getResult()) == 0;
    }

}
