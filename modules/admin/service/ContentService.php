<?php

namespace app\modules\admin\service;


class  ContentService
{
    const CONTENT_TYPE_BLOG = 'blog';
    const CONTENT_TYPE_NEWS = 'yangiliklar';


    public static function contentTypes() : array
    {
        return [
            self::CONTENT_TYPE_BLOG,
            self::CONTENT_TYPE_NEWS
        ];
    }
}
