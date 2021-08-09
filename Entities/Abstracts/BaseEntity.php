<?php
namespace Entities\Abstracts;


class BaseEntity{
    public $Id;
    public $CreatedAt;
    public $CreatedUser;
    public $UpdatedAt;
    public $UpdatedUser;
    public $DeletedAt;
    public $DeletedUser;
    function __clone()
    {
        $this->Id=0;
    }
}