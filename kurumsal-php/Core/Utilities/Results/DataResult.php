<?php 

namespace Core\Utilities\Results;

class DataResult extends Result implements IDataResult{
    public $data;
    public function __construct($data,bool $status,string $message=null)
    {
        $this->data=$data;
        parent::__construct($status,$message);
    }
}