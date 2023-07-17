<?php
namespace App\Utils;
class Util
{
    public function createDropdownHtml($array, $append_text = null)
    {
        $html = '';
        if (!empty($append_text)) {
            $html = '<option value="">' . $append_text . '</option>';
        }
        foreach ($array as $key => $value) {
            $html .= '<option value="' . $key . '">' . $value . '</option>';
        }

        return $html;
    }
}
?>