<?php
namespace app\modules\admin\service;


class  ContentService {


    public static function contentTypes()
    {
        return [
          'blog',
          'news'
        ];
    }
}
