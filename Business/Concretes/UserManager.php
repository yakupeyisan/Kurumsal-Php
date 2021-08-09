<?php

namespace Business\Concretes;

use Business\Abstracts\IUserService;
use Business\Constants\Messages;
use Business\Validations\UserValidation;
use Core\Business\BaseManager;
use Core\Utilities\Results\ErrorDataResult;
use Core\Utilities\Results\ErrorResult;
use Core\Utilities\Results\IDataResult;
use Core\Utilities\Results\IResult;
use Core\Utilities\Results\SuccessDataResult;
use Core\Utilities\Results\SuccessResult;
use DataAccess\Abstracts\IUserRepository;

class UserManager extends BaseManager implements IUserService
{
    //private $userRepository;
    public function __construct(IUserRepository $userRepository)
    {
        $this->repository = $userRepository;
        $this->validation= new UserValidation($userRepository);
    }
    function AddUser($entity,$password): IResult
    {
        if(gettype($entity)!="object"){
            return new ErrorResult(Messages::$TypeError);
        }
        $this->validation->AddEntity($entity);
        if ($this->validation->Run()) {
            try {
                $entity->Password=$password;
                if ($this->repository->Add($entity))
                    return new SuccessResult(Messages::$Added);
            } catch (\Exception $e) {
                $errors = explode("]", $e->getMessage());
                return new ErrorResult($errors[count($errors) - 1]);
            }
        }
        return new ErrorResult($this->validation->errors);
    }
    function GetClaims($entity): IDataResult
    {
        try {
            $data = $this->repository->GetClaims($entity);
            return new SuccessDataResult($data, Messages::$GetClaims);
        } catch (\Exception $e) {
            $errors = explode("]", $e->getMessage());
            return new ErrorDataResult([], $errors[count($errors) - 1]);
        }
    }
}
