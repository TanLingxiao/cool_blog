<?php
/**
 * Class WParsedown
 * author: hongweipeng
 */

class WParsedown extends Parsedown
{
    /**
     * 给默认的添加自定义宽高
     * @param $Excerpt
     * @return array|void
     */
    protected function inlineImage($Excerpt)
    {
        $Inline = parent::inlineImage($Excerpt);

        if (!isset($Inline['element']['attributes']['title'])) { return $Inline; }

        $size = $Inline['element']['attributes']['title'];

        if (preg_match('/^\d+x\d+$/', $size)) {
            list($width, $height) = explode('x', $size);

            $Inline['element']['attributes']['width'] = $width;
            $Inline['element']['attributes']['height'] = $height;

            unset ($Inline['element']['attributes']['title']);
        }

        return $Inline;
    }
}