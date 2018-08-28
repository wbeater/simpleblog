<?php

namespace app\helpers;

class StringHelper {
    public static function slug($str, $unicode=false, $separator='-') {
        $ret = '';
        if ($unicode) {
            $ret = mb_strtolower(trim(mb_substr(preg_replace('/[^\p{M}\p{L}\p{N}\-]/u', $separator, $str), 0, 50), '-_'));
        }
        else {
            $search = [ '|[áàảãạăắằẳẵặâấầẩẫậ]|ui', '|[đ]|ui', '|[éèẻẽẹêếềểễệ]|ui', '|[íìỉĩị]|ui', '|[óòỏõọôốồổỗộơớờởỡợ]|ui', '|[úùủũụưứừửữự]|ui', '|[ýỳỷỹỵ]|ui', '|[^a-zA-Z0-9]+|' ];
            $replace = ['a', 'd', 'e', 'i', 'o', 'u', 'y', $separator];
            $ret = strtolower(preg_replace($search, $replace, $str));
        }
        
        return trim($ret, " \t\n\r\0\x0B.-_");
    }
}