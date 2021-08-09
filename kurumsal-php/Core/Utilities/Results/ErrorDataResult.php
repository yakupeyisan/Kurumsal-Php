<?php 

namespace Core\Utilities\Results;

class ErrorDataResult extends DataResult implements IDataResult{
    public function __construct($data,string $message=null)
    {
        parent::__construct($data,false,$message);
    }
}