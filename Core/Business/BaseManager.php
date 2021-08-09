<?php 
namespace Core\Business;

use Business\Constants\Messages;
use Core\Utilities\Results\ErrorDataResult;
use Core\Utilities\Results\ErrorResult;
use Core\Utilities\Results\IDataResult;
use Core\Utilities\Results\IResult;
use Core\Utilities\Results\SuccessDataResult;
use Core\Utilities\Results\SuccessResult;

abstract class BaseManager 
{
    public $repository;
    public $validation;
    function GetAll($filter = null,int $page=0): IDataResult
    {
        try {
            $page=($page<0)?0:$page;
            $data = $this->repository->GetAll($filter,$page);
            return new SuccessDataResult($data, Messages::$GetAll);
        } catch (\Exception $e) {
            $errors = explode("]", $e->getMessage());
            return new ErrorDataResult([], $errors[count($errors) - 1]);
        }
    }
    function Get($filter): IDataResult
    {
        try {
            if(count((array)$filter)==0)
                return new SuccessDataResult([], Messages::$GetErrorFilter);
            $data = $this->repository->Get($filter);
            return new SuccessDataResult($data, Messages::$Get);
        } catch (\Exception $e) {
            $errors = explode("]", $e->getMessage());
            return new ErrorDataResult([], $errors[count($errors) - 1]);
        }
    }
    function Add($entity): IResult
    {
        if(gettype($entity)!="object"){
            return new ErrorResult(Messages::$TypeError);
        }
        $this->validation->AddEntity($entity);
        if ($this->validation->Run()) {
            try {
                if ($this->repository->Add($entity))
                    return new SuccessResult(Messages::$Added);
            } catch (\Exception $e) {
                $errors = explode("]", $e->getMessage());
                return new ErrorResult($errors[count($errors) - 1]);
            }
        }
        return new ErrorResult($this->validation->errors);
    }
    function Update($entity): IResult
    {
        if(gettype($entity)!="object"){
            return new ErrorResult(Messages::$TypeError);
        }
        $this->validation->AddEntity($entity);
        if ($this->validation->Run()) {
            try {
                if ($this->repository->Update($entity))
                    return new SuccessResult(Messages::$Updated);
            } catch (\Exception $e) {
                $errors = explode("]", $e->getMessage());
                return new ErrorResult($errors[count($errors) - 1]);
            }
        }
        return new ErrorResult($this->validation->errors);
    }
    function Delete($entity): IResult
    {
        try {
            if ($this->repository->Delete($entity->Id))
                return new SuccessResult(Messages::$Deleted);
        } catch (\Exception $e) {
            $errors = explode("]", $e->getMessage());
            return new ErrorResult($errors[count($errors) - 1]);
        }
    }
    
}
