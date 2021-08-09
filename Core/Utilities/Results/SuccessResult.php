<?php 

namespace Core\Utilities\Results;

class SuccessResult extends Result{
    public function __construct(string $message=null)
    {
        parent::__construct(true,$message);
    }
}