<?php 
namespace Business\Constants;

use CodeIgniter\HTTP\IncomingRequest;
use Core\Entities\IDto;
use Core\Entities\IEntity;

class PostEntityMapper
{
    public static function PostMapper(IncomingRequest $request,IEntity $entity){
        foreach (get_object_vars($entity) as $key => $value) {
            if($request->getVar($key)!=""){
                $entity->{$key}=$request->getVar($key);
            }
        }
        return $entity;
    }
    public static function PostMapperDto(IncomingRequest $request,IDto $entity){
        foreach (get_object_vars($entity) as $key => $value) {
            if($request->getVar($key)!=""){
                $entity->{$key}=$request->getVar($key);
            }
        }
        return $entity;
    }
    public static function ClearEmpty(IEntity $entity){
        foreach (get_object_vars($entity) as $key => $value) {
            if($value==null || $value==""){
                unset($entity->{$key});
            }
        }
        return $entity;
    }
}
