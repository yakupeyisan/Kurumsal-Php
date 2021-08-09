<?php 
namespace Business\Validations;

use Business\Validations\Abstracts\Validation;
use DataAccess\Abstracts\IUserRepository;
use Entities\Concretes\User;

class UserValidation extends Validation
{
    public IUserRepository $userRepository;
    function __construct(IUserRepository $userRepository)
    {
        $this->userRepository=$userRepository;
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
    public function CheckSurName():bool
    {
        if($this->entity->Surname!=null){
            return true;
        }
        $this->errors="Surname is required";
        return false;
    }
    public function CheckUnique():bool
    {
        $entity=[
            "Email"=>$this->entity->Email
        ];
        if($this->userRepository->IsUnique($entity,$this->entity->Id)){
            return true;
        }
        $this->errors="Record is not unique or not changes";
        return false;
    }
    public function CheckEmail():bool
    {
        if (filter_var($this->entity->Email, FILTER_VALIDATE_EMAIL)) {

            return true;
        }
        $this->errors="Invalid email format";
        return false;
    }
    public function CheckPasswordStrength():bool {
        $returnVal = True;
        if ( strlen($this->entity->Password) < 8 ) {
            $this->errors="Password must be at least 8 characters long.";
            $returnVal = False;
        }
    
        if ( !preg_match("#[0-9]+#", $this->entity->Password) ) {
            $this->errors.="-Password must contain numbers.";
            $returnVal = False;
        }
    
        if ( !preg_match("#[a-z]+#", $this->entity->Password) ) {
            $this->errors.="-Password must contain lowercase characters.";
            $returnVal = False;
        }
    
        if ( !preg_match("#[A-Z]+#", $this->entity->Password) ) {
            $this->errors.="-Password must contain uppercase characters.";
            $returnVal = False;
        }
    
        if ( !preg_match("/[\'^£$%&*()}{@#~?><>,|.=_+!-]/", $this->entity->Password) ) {
            $this->errors.="-Password must contain at least 1 capital letter(s)";
            $returnVal = False;
        }
    
        return $returnVal;
    
    }

}
