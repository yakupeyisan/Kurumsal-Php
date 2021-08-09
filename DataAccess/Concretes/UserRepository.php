<?php
namespace DataAccess\Concretes;

use Core\DataAccess\SignedSoftwareFramework\RepositoryBase;
use DataAccess\Abstracts\IUserRepository;
use Entities\Concretes\User;

class UserRepository extends RepositoryBase implements IUserRepository
{
    function __construct()
    {
        parent::__construct("Users",get_class(new User()));
    }
    public function IsUnique($filter,$Id=null): bool
    {
        $builder = $this->db->table($this->table);
        $builder->where($filter);
        $builder->where("Id !=",$Id);
        return count($builder->get()->getResult()) == 0;
    }
    public function GetClaims($entity): array
    {
        $builder = $this->db->table("UserOperationClaims")->select("Name");
        $builder->join('OperationClaims', 'UserOperationClaims.OperationClaimId = OperationClaims.Id', 'left');
        $builder->where("UserOperationClaims.UserId",$entity->Id);
        $claimsObj=$builder->get()->getResult();
        $result=[];
        foreach ($claimsObj as $key => $value) {
            $result[]=$value->Name;
        }
        return $result;
    }

}
