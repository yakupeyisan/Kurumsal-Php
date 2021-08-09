<?php 

namespace Core\Utilities\Results;

class Result implements IResult{
    public bool $success;
    public string $message;
    public function __construct(bool $success, string $message=null)
    {
        $this->success=$success;
        $this->message=$message;
    }

}