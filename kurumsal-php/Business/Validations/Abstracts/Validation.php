<?php 
namespace Business\Validations\Abstracts;

use CodeIgniter\Validation\Exceptions\ValidationException;
use Entities\Concretes\User;

abstract class Validation
{
    public $methods;
    protected $entity;
    public $errors="";
    function __construct($child)
    {
        $this->child=$child;
        $this->methods=get_class_methods($child);
    }
    public function AddEntity($entity)
    {
        $this->entity=$entity;
    }
    public function Run()
    {
        for ($i=0; $i < count($this->methods) ; $i++) { 
            if($this->methods[$i]!="Run" && $this->methods[$i]!="AddEntity" && $i!=0){
                if(!$this->child->{$this->methods[$i]}())
                    return false;
                    //throw new ValidationException($this->errors);
            }
        }
        return true;
    }
}
