<?php 

namespace Core\Utilities\Results;

class SuccessDataResult extends DataResult implements IDataResult{
    public function __construct($data,string $message=null)
    {
        parent::__construct($data,true,$message);
    }
}