<?php

date_default_timezone_set('Europe/Bratislava');
require_once("Database.php");

function remove_accents($text)
{
    $trans = array(
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Ç' => 'C', 'È' => 'E',
        'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N',
        'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
        'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
        'å' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i',
        'î' => 'i', 'ï' => 'i', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
        'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ÿ' => 'y', 'Ā' => 'A',
        'ā' => 'a', 'Ă' => 'A', 'ă' => 'a', 'Ą' => 'A', 'ą' => 'a', 'Ć' => 'C', 'ć' => 'c', 'Ĉ' => 'C',
        'ĉ' => 'c', 'Ċ' => 'C', 'ċ' => 'c', 'Č' => 'C', 'č' => 'c', 'Ď' => 'D', 'ď' => 'd', 'Đ' => 'D',
        'đ' => 'd', 'Ē' => 'E', 'ē' => 'e', 'Ĕ' => 'E', 'ĕ' => 'e', 'Ė' => 'E', 'ė' => 'e', 'Ę' => 'E',
        'ę' => 'e', 'Ě' => 'E', 'ě' => 'e', 'Ĝ' => 'G', 'ĝ' => 'g', 'Ğ' => 'G', 'ğ' => 'g', 'Ġ' => 'G',
        'ġ' => 'g', 'Ģ' => 'G', 'ģ' => 'g', 'Ĥ' => 'H', 'ĥ' => 'h', 'Ħ' => 'H', 'ħ' => 'h', 'Ĩ' => 'I',
        'ĩ' => 'i', 'Ī' => 'I', 'ī' => 'i', 'Ĭ' => 'I', 'ĭ' => 'i', 'Į' => 'I', 'į' => 'i', 'İ' => 'I',
        'ı' => 'i', 'Ĵ' => 'J', 'ĵ' => 'j', 'Ķ' => 'K', 'ķ' => 'k', 'Ĺ' => 'L', 'ĺ' => 'l', 'Ļ' => 'L',
        'ļ' => 'l', 'Ľ' => 'L', 'ľ' => 'l', 'Ŀ' => 'L', 'ŀ' => 'l', 'Ł' => 'L', 'ł' => 'l', 'Ń' => 'N',
        'ń' => 'n', 'Ņ' => 'N', 'ņ' => 'n', 'Ň' => 'N', 'ň' => 'n', 'ŉ' => 'n', 'Ō' => 'O', 'ō' => 'o',
        'Ŏ' => 'O', 'ŏ' => 'o', 'Ő' => 'O', 'ő' => 'o', 'Ŕ' => 'R', 'ŕ' => 'r', 'Ŗ' => 'R', 'ŗ' => 'r',
        'Ř' => 'R', 'ř' => 'r', 'Ś' => 'S', 'ś' => 's', 'Ŝ' => 'S', 'ŝ' => 's', 'Ş' => 'S', 'ş' => 's',
        'Š' => 'S', 'š' => 's', 'Ţ' => 'T', 'ţ' => 't', 'Ť' => 'T', 'ť' => 't', 'Ŧ' => 'T', 'ŧ' => 't',
        'Ũ' => 'U', 'ũ' => 'u', 'Ū' => 'U', 'ū' => 'u', 'Ŭ' => 'U', 'ŭ' => 'u', 'Ů' => 'U', 'ů' => 'u',
        'Ű' => 'U', 'ű' => 'u', 'Ų' => 'U', 'ų' => 'u', 'Ŵ' => 'W', 'ŵ' => 'w', 'Ŷ' => 'Y', 'ŷ' => 'y',
        'Ÿ' => 'Y', 'Ź' => 'Z', 'ź' => 'z', 'Ż' => 'Z', 'ż' => 'z', 'Ž' => 'Z', 'ž' => 'z', 'ƀ' => 'b',
        'Ɓ' => 'B', 'Ƃ' => 'B', 'ƃ' => 'b', 'Ƈ' => 'C', 'ƈ' => 'c', 'Ɗ' => 'D', 'Ƌ' => 'D', 'ƌ' => 'd',
        'Ƒ' => 'F', 'ƒ' => 'f', 'Ɠ' => 'G', 'Ɨ' => 'I', 'Ƙ' => 'K', 'ƙ' => 'k', 'ƚ' => 'l', 'Ɲ' => 'N',
        'ƞ' => 'n', 'Ɵ' => 'O', 'Ơ' => 'O', 'ơ' => 'o', 'Ƥ' => 'P', 'ƥ' => 'p', 'ƫ' => 't', 'Ƭ' => 'T',
        'ƭ' => 't', 'Ʈ' => 'T', 'Ư' => 'U', 'ư' => 'u', 'Ʋ' => 'V', 'Ƴ' => 'Y', 'ƴ' => 'y', 'Ƶ' => 'Z',
        'ƶ' => 'z', 'ǅ' => 'D', 'ǈ' => 'L', 'ǋ' => 'N', 'Ǎ' => 'A', 'ǎ' => 'a', 'Ǐ' => 'I', 'ǐ' => 'i',
        'Ǒ' => 'O', 'ǒ' => 'o', 'Ǔ' => 'U', 'ǔ' => 'u', 'Ǖ' => 'U', 'ǖ' => 'u', 'Ǘ' => 'U', 'ǘ' => 'u',
        'Ǚ' => 'U', 'ǚ' => 'u', 'Ǜ' => 'U', 'ǜ' => 'u', 'Ǟ' => 'A', 'ǟ' => 'a', 'Ǡ' => 'A', 'ǡ' => 'a',
        'Ǥ' => 'G', 'ǥ' => 'g', 'Ǧ' => 'G', 'ǧ' => 'g', 'Ǩ' => 'K', 'ǩ' => 'k', 'Ǫ' => 'O', 'ǫ' => 'o',
        'Ǭ' => 'O', 'ǭ' => 'o', 'ǰ' => 'j', 'ǲ' => 'D', 'Ǵ' => 'G', 'ǵ' => 'g', 'Ǹ' => 'N', 'ǹ' => 'n',
        'Ǻ' => 'A', 'ǻ' => 'a', 'Ǿ' => 'O', 'ǿ' => 'o', 'Ȁ' => 'A', 'ȁ' => 'a', 'Ȃ' => 'A', 'ȃ' => 'a',
        'Ȅ' => 'E', 'ȅ' => 'e', 'Ȇ' => 'E', 'ȇ' => 'e', 'Ȉ' => 'I', 'ȉ' => 'i', 'Ȋ' => 'I', 'ȋ' => 'i',
        'Ȍ' => 'O', 'ȍ' => 'o', 'Ȏ' => 'O', 'ȏ' => 'o', 'Ȑ' => 'R', 'ȑ' => 'r', 'Ȓ' => 'R', 'ȓ' => 'r',
        'Ȕ' => 'U', 'ȕ' => 'u', 'Ȗ' => 'U', 'ȗ' => 'u', 'Ș' => 'S', 'ș' => 's', 'Ț' => 'T', 'ț' => 't',
        'Ȟ' => 'H', 'ȟ' => 'h', 'Ƞ' => 'N', 'ȡ' => 'd', 'Ȥ' => 'Z', 'ȥ' => 'z', 'Ȧ' => 'A', 'ȧ' => 'a',
        'Ȩ' => 'E', 'ȩ' => 'e', 'Ȫ' => 'O', 'ȫ' => 'o', 'Ȭ' => 'O', 'ȭ' => 'o', 'Ȯ' => 'O', 'ȯ' => 'o',
        'Ȱ' => 'O', 'ȱ' => 'o', 'Ȳ' => 'Y', 'ȳ' => 'y', 'ȴ' => 'l', 'ȵ' => 'n', 'ȶ' => 't', 'ȷ' => 'j',
        'Ⱥ' => 'A', 'Ȼ' => 'C', 'ȼ' => 'c', 'Ƚ' => 'L', 'Ⱦ' => 'T', 'ȿ' => 's', 'ɀ' => 'z', 'Ƀ' => 'B',
        'Ʉ' => 'U', 'Ɇ' => 'E', 'ɇ' => 'e', 'Ɉ' => 'J', 'ɉ' => 'j', 'ɋ' => 'q', 'Ɍ' => 'R', 'ɍ' => 'r',
        'Ɏ' => 'Y', 'ɏ' => 'y', 'ɓ' => 'b', 'ɕ' => 'c', 'ɖ' => 'd', 'ɗ' => 'd', 'ɟ' => 'j', 'ɠ' => 'g',
        'ɦ' => 'h', 'ɨ' => 'i', 'ɫ' => 'l', 'ɬ' => 'l', 'ɭ' => 'l', 'ɱ' => 'm', 'ɲ' => 'n', 'ɳ' => 'n',
        'ɵ' => 'o', 'ɼ' => 'r', 'ɽ' => 'r', 'ɾ' => 'r', 'ʂ' => 's', 'ʄ' => 'j', 'ʈ' => 't', 'ʉ' => 'u',
        'ʋ' => 'v', 'ʐ' => 'z', 'ʑ' => 'z', 'ʝ' => 'j', 'ʠ' => 'q', 'ͣ' => 'a', 'ͤ' => 'e', 'ͥ' => 'i',
        'ͦ' => 'o', 'ͧ' => 'u', 'ͨ' => 'c', 'ͩ' => 'd', 'ͪ' => 'h', 'ͫ' => 'm', 'ͬ' => 'r', 'ͭ' => 't',
        'ͮ' => 'v', 'ͯ' => 'x', 'ᵢ' => 'i', 'ᵣ' => 'r', 'ᵤ' => 'u', 'ᵥ' => 'v', 'ᵬ' => 'b', 'ᵭ' => 'd',
        'ᵮ' => 'f', 'ᵯ' => 'm', 'ᵰ' => 'n', 'ᵱ' => 'p', 'ᵲ' => 'r', 'ᵳ' => 'r', 'ᵴ' => 's', 'ᵵ' => 't',
        'ᵶ' => 'z', 'ᵻ' => 'i', 'ᵽ' => 'p', 'ᵾ' => 'u', 'ᶀ' => 'b', 'ᶁ' => 'd', 'ᶂ' => 'f', 'ᶃ' => 'g',
        'ᶄ' => 'k', 'ᶅ' => 'l', 'ᶆ' => 'm', 'ᶇ' => 'n', 'ᶈ' => 'p', 'ᶉ' => 'r', 'ᶊ' => 's', 'ᶌ' => 'v',
        'ᶍ' => 'x', 'ᶎ' => 'z', 'ᶏ' => 'a', 'ᶑ' => 'd', 'ᶒ' => 'e', 'ᶖ' => 'i', 'ᶙ' => 'u', '᷊' => 'r',
        'ᷗ' => 'c', 'ᷚ' => 'g', 'ᷜ' => 'k', 'ᷝ' => 'l', 'ᷠ' => 'n', 'ᷣ' => 'r', 'ᷤ' => 's', 'ᷦ' => 'z',
        'Ḁ' => 'A', 'ḁ' => 'a', 'Ḃ' => 'B', 'ḃ' => 'b', 'Ḅ' => 'B', 'ḅ' => 'b', 'Ḇ' => 'B', 'ḇ' => 'b',
        'Ḉ' => 'C', 'ḉ' => 'c', 'Ḋ' => 'D', 'ḋ' => 'd', 'Ḍ' => 'D', 'ḍ' => 'd', 'Ḏ' => 'D', 'ḏ' => 'd',
        'Ḑ' => 'D', 'ḑ' => 'd', 'Ḓ' => 'D', 'ḓ' => 'd', 'Ḕ' => 'E', 'ḕ' => 'e', 'Ḗ' => 'E', 'ḗ' => 'e',
        'Ḙ' => 'E', 'ḙ' => 'e', 'Ḛ' => 'E', 'ḛ' => 'e', 'Ḝ' => 'E', 'ḝ' => 'e', 'Ḟ' => 'F', 'ḟ' => 'f',
        'Ḡ' => 'G', 'ḡ' => 'g', 'Ḣ' => 'H', 'ḣ' => 'h', 'Ḥ' => 'H', 'ḥ' => 'h', 'Ḧ' => 'H', 'ḧ' => 'h',
        'Ḩ' => 'H', 'ḩ' => 'h', 'Ḫ' => 'H', 'ḫ' => 'h', 'Ḭ' => 'I', 'ḭ' => 'i', 'Ḯ' => 'I', 'ḯ' => 'i',
        'Ḱ' => 'K', 'ḱ' => 'k', 'Ḳ' => 'K', 'ḳ' => 'k', 'Ḵ' => 'K', 'ḵ' => 'k', 'Ḷ' => 'L', 'ḷ' => 'l',
        'Ḹ' => 'L', 'ḹ' => 'l', 'Ḻ' => 'L', 'ḻ' => 'l', 'Ḽ' => 'L', 'ḽ' => 'l', 'Ḿ' => 'M', 'ḿ' => 'm',
        'Ṁ' => 'M', 'ṁ' => 'm', 'Ṃ' => 'M', 'ṃ' => 'm', 'Ṅ' => 'N', 'ṅ' => 'n', 'Ṇ' => 'N', 'ṇ' => 'n',
        'Ṉ' => 'N', 'ṉ' => 'n', 'Ṋ' => 'N', 'ṋ' => 'n', 'Ṍ' => 'O', 'ṍ' => 'o', 'Ṏ' => 'O', 'ṏ' => 'o',
        'Ṑ' => 'O', 'ṑ' => 'o', 'Ṓ' => 'O', 'ṓ' => 'o', 'Ṕ' => 'P', 'ṕ' => 'p', 'Ṗ' => 'P', 'ṗ' => 'p',
        'Ṙ' => 'R', 'ṙ' => 'r', 'Ṛ' => 'R', 'ṛ' => 'r', 'Ṝ' => 'R', 'ṝ' => 'r', 'Ṟ' => 'R', 'ṟ' => 'r',
        'Ṡ' => 'S', 'ṡ' => 's', 'Ṣ' => 'S', 'ṣ' => 's', 'Ṥ' => 'S', 'ṥ' => 's', 'Ṧ' => 'S', 'ṧ' => 's',
        'Ṩ' => 'S', 'ṩ' => 's', 'Ṫ' => 'T', 'ṫ' => 't', 'Ṭ' => 'T', 'ṭ' => 't', 'Ṯ' => 'T', 'ṯ' => 't',
        'Ṱ' => 'T', 'ṱ' => 't', 'Ṳ' => 'U', 'ṳ' => 'u', 'Ṵ' => 'U', 'ṵ' => 'u', 'Ṷ' => 'U', 'ṷ' => 'u',
        'Ṹ' => 'U', 'ṹ' => 'u', 'Ṻ' => 'U', 'ṻ' => 'u', 'Ṽ' => 'V', 'ṽ' => 'v', 'Ṿ' => 'V', 'ṿ' => 'v',
        'Ẁ' => 'W', 'ẁ' => 'w', 'Ẃ' => 'W', 'ẃ' => 'w', 'Ẅ' => 'W', 'ẅ' => 'w', 'Ẇ' => 'W', 'ẇ' => 'w',
        'Ẉ' => 'W', 'ẉ' => 'w', 'Ẋ' => 'X', 'ẋ' => 'x', 'Ẍ' => 'X', 'ẍ' => 'x', 'Ẏ' => 'Y', 'ẏ' => 'y',
        'Ẑ' => 'Z', 'ẑ' => 'z', 'Ẓ' => 'Z', 'ẓ' => 'z', 'Ẕ' => 'Z', 'ẕ' => 'z', 'ẖ' => 'h', 'ẗ' => 't',
        'ẘ' => 'w', 'ẙ' => 'y', 'ẚ' => 'a', 'Ạ' => 'A', 'ạ' => 'a', 'Ả' => 'A', 'ả' => 'a', 'Ấ' => 'A',
        'ấ' => 'a', 'Ầ' => 'A', 'ầ' => 'a', 'Ẩ' => 'A', 'ẩ' => 'a', 'Ẫ' => 'A', 'ẫ' => 'a', 'Ậ' => 'A',
        'ậ' => 'a', 'Ắ' => 'A', 'ắ' => 'a', 'Ằ' => 'A', 'ằ' => 'a', 'Ẳ' => 'A', 'ẳ' => 'a', 'Ẵ' => 'A',
        'ẵ' => 'a', 'Ặ' => 'A', 'ặ' => 'a', 'Ẹ' => 'E', 'ẹ' => 'e', 'Ẻ' => 'E', 'ẻ' => 'e', 'Ẽ' => 'E',
        'ẽ' => 'e', 'Ế' => 'E', 'ế' => 'e', 'Ề' => 'E', 'ề' => 'e', 'Ể' => 'E', 'ể' => 'e', 'Ễ' => 'E',
        'ễ' => 'e', 'Ệ' => 'E', 'ệ' => 'e', 'Ỉ' => 'I', 'ỉ' => 'i', 'Ị' => 'I', 'ị' => 'i', 'Ọ' => 'O',
        'ọ' => 'o', 'Ỏ' => 'O', 'ỏ' => 'o', 'Ố' => 'O', 'ố' => 'o', 'Ồ' => 'O', 'ồ' => 'o', 'Ổ' => 'O',
        'ổ' => 'o', 'Ỗ' => 'O', 'ỗ' => 'o', 'Ộ' => 'O', 'ộ' => 'o', 'Ớ' => 'O', 'ớ' => 'o', 'Ờ' => 'O',
        'ờ' => 'o', 'Ở' => 'O', 'ở' => 'o', 'Ỡ' => 'O', 'ỡ' => 'o', 'Ợ' => 'O', 'ợ' => 'o', 'Ụ' => 'U',
        'ụ' => 'u', 'Ủ' => 'U', 'ủ' => 'u', 'Ứ' => 'U', 'ứ' => 'u', 'Ừ' => 'U', 'ừ' => 'u', 'Ử' => 'U',
        'ử' => 'u', 'Ữ' => 'U', 'ữ' => 'u', 'Ự' => 'U', 'ự' => 'u', 'Ỳ' => 'Y', 'ỳ' => 'y', 'Ỵ' => 'Y',
        'ỵ' => 'y', 'Ỷ' => 'Y', 'ỷ' => 'y', 'Ỹ' => 'Y', 'ỹ' => 'y', 'Ỿ' => 'Y', 'ỿ' => 'y', 'ⁱ' => 'i',
        'ⁿ' => 'n', 'ₐ' => 'a', 'ₑ' => 'e', 'ₒ' => 'o', 'ₓ' => 'x', '⒜' => 'a', '⒝' => 'b', '⒞' => 'c',
        '⒟' => 'd', '⒠' => 'e', '⒡' => 'f', '⒢' => 'g', '⒣' => 'h', '⒤' => 'i', '⒥' => 'j', '⒦' => 'k',
        '⒧' => 'l', '⒨' => 'm', '⒩' => 'n', '⒪' => 'o', '⒫' => 'p', '⒬' => 'q', '⒭' => 'r', '⒮' => 's',
        '⒯' => 't', '⒰' => 'u', '⒱' => 'v', '⒲' => 'w', '⒳' => 'x', '⒴' => 'y', '⒵' => 'z', 'Ⓐ' => 'A',
        'Ⓑ' => 'B', 'Ⓒ' => 'C', 'Ⓓ' => 'D', 'Ⓔ' => 'E', 'Ⓕ' => 'F', 'Ⓖ' => 'G', 'Ⓗ' => 'H', 'Ⓘ' => 'I',
        'Ⓙ' => 'J', 'Ⓚ' => 'K', 'Ⓛ' => 'L', 'Ⓜ' => 'M', 'Ⓝ' => 'N', 'Ⓞ' => 'O', 'Ⓟ' => 'P', 'Ⓠ' => 'Q',
        'Ⓡ' => 'R', 'Ⓢ' => 'S', 'Ⓣ' => 'T', 'Ⓤ' => 'U', 'Ⓥ' => 'V', 'Ⓦ' => 'W', 'Ⓧ' => 'X', 'Ⓨ' => 'Y',
        'Ⓩ' => 'Z', 'ⓐ' => 'a', 'ⓑ' => 'b', 'ⓒ' => 'c', 'ⓓ' => 'd', 'ⓔ' => 'e', 'ⓕ' => 'f', 'ⓖ' => 'g',
        'ⓗ' => 'h', 'ⓘ' => 'i', 'ⓙ' => 'j', 'ⓚ' => 'k', 'ⓛ' => 'l', 'ⓜ' => 'm', 'ⓝ' => 'n', 'ⓞ' => 'o',
        'ⓟ' => 'p', 'ⓠ' => 'q', 'ⓡ' => 'r', 'ⓢ' => 's', 'ⓣ' => 't', 'ⓤ' => 'u', 'ⓥ' => 'v', 'ⓦ' => 'w',
        'ⓧ' => 'x', 'ⓨ' => 'y', 'ⓩ' => 'z', 'Ⱡ' => 'L', 'ⱡ' => 'l', 'Ɫ' => 'L', 'Ᵽ' => 'P', 'Ɽ' => 'R',
        'ⱥ' => 'a', 'ⱦ' => 't', 'Ⱨ' => 'H', 'ⱨ' => 'h', 'Ⱪ' => 'K', 'ⱪ' => 'k', 'Ⱬ' => 'Z', 'ⱬ' => 'z',
        'Ɱ' => 'M', 'ⱱ' => 'v', 'Ⱳ' => 'W', 'ⱳ' => 'w', 'ⱴ' => 'v', 'ⱸ' => 'e', 'ⱺ' => 'o', 'ⱼ' => 'j',
        'Ꝁ' => 'K', 'ꝁ' => 'k', 'Ꝃ' => 'K', 'ꝃ' => 'k', 'Ꝅ' => 'K', 'ꝅ' => 'k', 'Ꝉ' => 'L', 'ꝉ' => 'l',
        'Ꝋ' => 'O', 'ꝋ' => 'o', 'Ꝍ' => 'O', 'ꝍ' => 'o', 'Ꝑ' => 'P', 'ꝑ' => 'p', 'Ꝓ' => 'P', 'ꝓ' => 'p',
        'Ꝕ' => 'P', 'ꝕ' => 'p', 'Ꝗ' => 'Q', 'ꝗ' => 'q', 'Ꝙ' => 'Q', 'ꝙ' => 'q', 'Ꝛ' => 'R', 'ꝛ' => 'r',
        'Ꝟ' => 'V', 'ꝟ' => 'v', 'Ａ' => 'A', 'Ｂ' => 'B', 'Ｃ' => 'C', 'Ｄ' => 'D', 'Ｅ' => 'E', 'Ｆ' => 'F',
        'Ｇ' => 'G', 'Ｈ' => 'H', 'Ｉ' => 'I', 'Ｊ' => 'J', 'Ｋ' => 'K', 'Ｌ' => 'L', 'Ｍ' => 'M', 'Ｎ' => 'N',
        'Ｏ' => 'O', 'Ｐ' => 'P', 'Ｑ' => 'Q', 'Ｒ' => 'R', 'Ｓ' => 'S', 'Ｔ' => 'T', 'Ｕ' => 'U', 'Ｖ' => 'V',
        'Ｗ' => 'W', 'Ｘ' => 'X', 'Ｙ' => 'Y', 'Ｚ' => 'Z', 'ａ' => 'a', 'ｂ' => 'b', 'ｃ' => 'c', 'ｄ' => 'd',
        'ｅ' => 'e', 'ｆ' => 'f', 'ｇ' => 'g', 'ｈ' => 'h', 'ｉ' => 'i', 'ｊ' => 'j', 'ｋ' => 'k', 'ｌ' => 'l',
        'ｍ' => 'm', 'ｎ' => 'n', 'ｏ' => 'o', 'ｐ' => 'p', 'ｑ' => 'q', 'ｒ' => 'r', 'ｓ' => 's', 'ｔ' => 't',
        'ｕ' => 'u', 'ｖ' => 'v', 'ｗ' => 'w', 'ｘ' => 'x', 'ｙ' => 'y', 'ｚ' => 'z',
    );
    return strtr($text, $trans);
}

function addUser($meno, $priezvisko, $conn)
{
    $USERsql = "INSERT INTO user (meno, priezvisko) VALUES (?, ?)";
    $stmt = $conn->prepare($USERsql);
    try {
        $stmt->execute([$meno, $priezvisko]);
    } catch (PDOException $e) {
        return;
    }
}

function addConnection($id, $action, $timestamp, $conn)
{
    $CONsql = "INSERT INTO connections (user_id, action, time) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($CONsql);
    try {
        $stmt->execute([$id, $action, $timestamp]);
    } catch (PDOException $e) {
        return;
    }
}

function addIntoDatabase($link, $conn)
{
    $rawLink = str_replace("blob", "raw", $link);

    $lecture = curl_init();

    curl_setopt($lecture, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($lecture, CURLOPT_URL, "https://github.com$rawLink");

    curl_setopt($lecture, CURLOPT_RETURNTRANSFER, 1);

    $str = curl_exec($lecture);

    curl_close($lecture);
    $newSTR = mb_convert_encoding($str, "UTF-8", "UTF-16");
    $rows = explode("\n", $newSTR);
    foreach ($rows as $row) {
        $row = explode("\t", $row);
        if (($row[2] == "Timestamp") || count($row) == 1) {
            continue;
        }
        $menoPriezvisko = explode(" ", $row[0]);
        $meno = $menoPriezvisko[0];
        $priezvisko = $menoPriezvisko[1];
        if ($row[2][strlen($row[2]) - 1] == 'M') {
            $timestamp = date('Y-m-d H:i:s', date_create_from_format('m/d/Y, H:i:s A', $row[2])->getTimestamp());
        } else {
            $timestamp = date('Y-m-d H:i:s', date_create_from_format('d/m/Y, H:i:s', $row[2])->getTimestamp());
        }

        $sql = "SELECT id FROM user WHERE meno=? AND priezvisko=?";
        $sth = $conn->prepare($sql);
        $sth->execute([$meno, $priezvisko]);
        $user = $sth->fetch();

        if ($user == false) {
            addUser($meno, $priezvisko, $conn);
            $sqll = "SELECT id FROM user WHERE meno=? AND priezvisko=?";
            $st = $conn->prepare($sqll);
            $st->execute([$meno, $priezvisko]);
            $newU = $st->fetch();
            addConnection($newU["id"], $row[1], $timestamp, $conn);
        } else {
            addConnection($user["id"], $row[1], $timestamp, $conn);
        }
    }
}
$conn = (new Database())->createConnection();

if (isset($_GET["updated"])) {
    // create curl resource
    $ch = curl_init();

    // set url
    curl_setopt($ch, CURLOPT_URL, "https://github.com/apps4webte/curldata2021");

    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // $output contains the output string
    $output = curl_exec($ch);

    // close curl resource to free up system resources
    curl_close($ch);

    $dom = new DOMDocument();

    @$dom->loadHTML($output);

    $xpath = new DOMXPath($dom);
    $as = $xpath->query("//a[starts-with(@href, '/apps4webte/curldata2021/blob/main/')]");

    foreach ($as as $a) {
        $link = $a->attributes[3]->textContent;
        addIntoDatabase($link, $conn);
    }
}
?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <title>Zadanie 4 WEBTE2</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="package/dist/chart.js"></script>
    <script>

    </script>
</head>

<body>
    <?php
    $dates = array();
    echo "<table class='sortable'><caption>Účasti študentov</caption>
        <tr>
          <th class='item'>Meno študenta</th>";
    $counter = 1;

    $sql = "SELECT time FROM connections ORDER BY time ASC";
    $result = $conn->query($sql);
    $times = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach($times as $time) {
        $date = substr($time["time"], 0, 10);
        $day = substr($date, -2, 2);
        $month = substr($date, -5, 2);
        $year = substr($date, 0, 4);
        $new_DATE = $day . "/" . $month . "/" . $year;
        if(in_array($new_DATE, $dates)){
            continue;
        }
        array_push($dates, $new_DATE);
    }
    foreach($dates as $date) {
        echo "<th class='disabled'>";
        echo "(";
        echo $counter;
        echo ".) ";
        echo $date;
        echo "</th>";
        $counter++;
    }

    echo "<th class='item'>Celkový počet účastí na prednáškach</th>
              <th class='item'>Celkový počet minút strávených na prednáškach</th>
        </tr>";
    $counter = 1;
    do {
        $minutes = array();

        $sqlQ = "SELECT *  FROM user, connections WHERE connections.user_id=user.id AND user.id=? ORDER BY connections.time ASC";
        $s = $conn->prepare($sqlQ);
        $s->execute([$counter]);
        $user = $s->fetchAll();


        if (count($user) == 0) {
            break;
        }
        echo "<tr>";
        echo "<td>";

        echo remove_accents(ucfirst($user[0]["priezvisko"]));
        echo " ";
        echo remove_accents(ucfirst($user[0]["meno"]));
        echo "</td>";
        for ($i = 0; $i < count($dates); $i++) {
            $log = array();
            //cyklus v ramci datumov
            echo "<td>";
            $difference = 0;
            for ($j = 0; $j < count($user); $j++) {
                //cyklus v ramci timestampov usera
                $start_date = DateTime::createFromFormat("Y-m-d H:i:s", $user[$j]["time"]);
                $sd = $start_date->format('d/m/Y');
                if (($sd == $dates[$i]) && (($user[$j]["action"] == "Joined"))) {
                    //datumy sa rovnaju a action je joined
                    if (($j + 1) == count($user)) {
                        array_push($log, "Príchod: " . $start_date->format('d/m/Y H:i:s'));
                        //posledna hodnota v poli timestampov
                        $hH = $start_date->format('Y-m-d') . " 23:59:59";
                        $dH = $start_date->format('Y-m-d') . " 00:00:00";
                        $sqlT = "SELECT connections.time  FROM user, connections WHERE connections.time BETWEEN ? AND ? ORDER BY connections.time DESC";

                        $sq = $conn->prepare($sqlT);
                        $sq->execute([$dH, $hH]);
                        $dts = $sq->fetchAll();
                        $last_date = DateTime::createFromFormat("Y-m-d H:i:s", $dts[0]["time"]);
                        $dif = $start_date->diff($last_date);
                        $difference += $dif->h * 60;
                        $difference += $dif->i;
                        $difference += $dif->s / 60;
                        break;
                    }
                    $next_date = DateTime::createFromFormat("Y-m-d H:i:s", $user[$j + 1]["time"]);
                    $nd = $next_date->format('d/m/Y');
                    if ($nd == $dates[$i]) {
                        array_push($log, "Príchod: " . $start_date->format('d/m/Y H:i:s'));
                        array_push($log, "Odchod: " . $next_date->format('d/m/Y H:i:s'));
                        //pocitanie rozdielu
                        $dif = $start_date->diff($next_date);
                        $difference += $dif->h * 60;
                        $difference += $dif->i;
                        $difference += $dif->s / 60;
                    } else {
                        array_push($log, "Príchod: " . $start_date->format('d/m/Y H:i:s'));
                        // pocitanie rozdielu s poslednym casom v dni
                        $hH = $start_date->format('Y-m-d') . " 23:59:59";
                        $dH = $start_date->format('Y-m-d') . " 00:00:00";
                        $sqlT = "SELECT connections.time  FROM user, connections WHERE connections.time BETWEEN ? AND ? ORDER BY connections.time DESC";

                        $sq = $conn->prepare($sqlT);
                        $sq->execute([$dH, $hH]);
                        $dts = $sq->fetchAll();
                        $last_date = DateTime::createFromFormat("Y-m-d H:i:s", $dts[0]["time"]);
                        $dif = $start_date->diff($last_date);
                        $difference += $dif->h * 60;
                        $difference += $dif->i;
                        $difference += $dif->s / 60;
                    }
                } else if (($sd == $dates[$i]) && ($user[$j]["action"] == "Left")) {
                    //nepocitanie rozdielu, pokracuj dalej, datumy sa rovnaju a akcia je left
                    continue;
                } else {
                    //datumy sa nerovnaju, prejdi na druhy datum
                    continue;
                }
            }
            if ($difference != 0) {
                array_push($minutes, floor($difference));
            }
            echo '<div class="container-sm">
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn cstm btn-sm ';
            $split = explode(" ", end($log));
            if ($split[0] == "Príchod:") {
                echo "btn-danger";
            } else {
                echo 'btn-success';
            }
            echo '" data-toggle="modal" data-target="#myModal'

                . $i . $counter . '">';

            echo floor($difference);

            echo '</button>
          
            <!-- Modal -->
            <div class="modal fade" id="myModal' . $i . $counter . '" role="dialog">
              <div class="modal-dialog">
              
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="color: black">Detail účastí študenta</h4>
                  </div>
                  <div class="modal-body">';
            foreach ($log as $item) {
                echo '<p>' . $item . '</p>';
            }
            echo '</div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Zatvoriť</button>
                  </div>
                </div>
                
              </div>
            </div>
            
          </div>';

            echo "</td>";
        }
        $counter++;
        echo "<td>";
        echo count($minutes);
        echo "</td>";
        echo "<td>";
        $overall = 0;
        foreach ($minutes as $index) {
            $overall += $index;
        }
        echo $overall;
        echo "</td>";
        echo "</tr>";
    } while (count($user) != 0);    
    echo "</table>";
    ?>

    <a href="index.php?updated=true">Update database</a>
    <div class="chart-container">
        <canvas id="myChart"></canvas>
    </div>

    <?php
        $numOfCons = array();
        foreach($dates as $date){
            $early_date = $date . ' 00:00:00';
            $late_date = $date . ' 23:59:59';
            $eDate = date('Y-m-d H:i:s', date_create_from_format('d/m/Y H:i:s', $early_date)->getTimestamp());
            $lDate = date('Y-m-d H:i:s', date_create_from_format('d/m/Y H:i:s', $late_date)->getTimestamp());
            $sql = "SELECT DISTINCT user_id FROM connections  WHERE time BETWEEN ? AND ? GROUP BY user_id";
            $sq = $conn->prepare($sql);
            $sq->execute([$eDate, $lDate]);
            $con = $sq->fetchAll();
            array_push($numOfCons, count($con));
        }
        
    ?>
    <script>
        var dates = <?php echo json_encode($dates); ?>;
        var cons = <?php echo json_encode($numOfCons); ?>;
        var ctx = document.getElementById('myChart');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Prítomnosť na prednáške(počet študentov)',
                    data: cons,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script src="https://www.kryogenix.org/code/browser/sorttable/sorttable.js"></script>

</body>

</html>