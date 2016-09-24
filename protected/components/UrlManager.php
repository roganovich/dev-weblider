<?php
class UrlManager extends CBaseUrlRule
{

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if($pathInfo == Materials::getIndexPage()->url) {
            header('Location: /');
            Yii::app()->end();
        };
        return PathInfo::getInstance()->parseUrl($request->getPathInfo());
    } 
    
    public function createUrl($manager, $route, $params, $ampersand)
    {
        $return = false;
        if($route){
            $routePart = explode("/", trim($route,'/'));
            if(count($routePart) >= 2){
                if(in_array($routePart[0], array_keys(Materials::$types)) && $routePart[1] == 'view' && isset($params['id'])){
                    $material = Materials::model()->findByPk($params['id']);
                    if($material){
                        unset($params['id']);
                        $return = $material->url;
                        if(!empty($params)){
                            $return.='?'.$manager->createPathInfo($params,'=',$ampersand);
                        }
                    }
                }
            }
        }
        return $return;
    }    
}