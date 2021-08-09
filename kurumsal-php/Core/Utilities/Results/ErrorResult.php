<?php 

namespace Core\Utilities\Results;

class ErrorResult extends Result{
    public function __construct(string $message=null)
    {
        parent::__construct(false,$message);
    }
}