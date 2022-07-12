<?php

class PhoneKeyboardConverter
{
    private $_matrix = [0=>' ', 2=>['A','B','C'],
            ['D','E','F'], ['G','H','I'], ['J','K','L'],
            ['M','N','O'], ['P','Q','R'], ['S','T','U'],
            ['V','W','Y','Z']];

    public function convertToNumeric(string $string_to_convert) : string
    {
        $return_string = '';
        $new_string_array = str_split($string_to_convert);

        foreach($new_string_array as $key => $char) {
            $return_string .= $this->searchMatrixForLetter($char);
            if (isset($new_string_array[($key+1)]))
                $return_string .= ',';
        }

        return $return_string;
    }

    public function convertToString(string $string_to_convert) : string
    {
        $return_string = '';
        $new_numbers_array = explode(',', $string_to_convert);

        foreach($new_numbers_array as $number) {
            $return_string .= $this->findLetterByNumbers($number);
        }

        return $return_string;
    }

    private function findLetterByNumbers(string $numbers) : string
    {
        return $_matrix[substr($numbers,0,1)][(strlen($numbers)-1)];
    }

    private function searchMatrixForLetter(string $char) : string
    {
        $return_string = '';

        foreach($_matrix as $number => $chars) {
            if (is_array($chars)) {
                if (in_array($char, $chars)) {
                    for($i = 0; $i < (array_search($char, $chars)+1); $i++) {
                        $return_string .= $number;
                    }
                    return $return_string;
                }
            } elseif ($chars === $char)
                return $number;
        }
    }
}
