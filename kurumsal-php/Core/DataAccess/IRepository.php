<?php
namespace Core\DataAccess;
interface IRepository{
    function GetAll($filter=null, int $page = 0, int $limit = 1);
    function Get($filter);
    function Add($entity);
    function Update($entity);
    function Delete(int $id);
}