<?php

class Helper
{
    /**
     * Checks if passwords match
     * @param string $pw1
     * @param string $pw2
     * @return bool
     */
    function passwordsMatch(string $pw1, string $pw2): bool
    {
        return $pw1 == $pw2;
    }

    /**
     * Checks if string has a valid length
     * @param string $str
     * @param int $min
     * @param int $max
     * @return bool
     */
    function isValidLength(string $str, int $min = 8, int $max = 20): bool
    {
        $str_length = strlen($str);
        return $str_length >= $min && $str_length <= $max;
    }

    /**
     * Checks if array has empty string ("")
     * @param array $postValues
     * @return bool
     */
    function isEmpty(array $postValues): bool
    {
        if (in_array("", $postValues)) return true;
        return false;
    }

    /**
     * Checks if a password is secure:
     * - Contains at least an uppercase letter
     * - Contains at least a downcase letter
     * - Contains at least a digit
     * @param string $pw
     * @return bool
     */
    function isSecure(string $pw): bool
    {
        return preg_match('/[a-z]/', $pw) &&
            preg_match('/[A-Z]/', $pw) &&
            preg_match('/[0-9]/', $pw);
    }

    /**
     * @param string $val
     * @param string $type
     * @param string $attr
     * @return void
     */
    function keepValues(string $val, string $type, string $attr = ''): void
    {
        switch ($type) {
            case 'textbox':
                echo "value = '$val'";
                break;
            case 'textarea':
                echo $val;
                break;
            case 'select':
                if ($val == $attr) echo 'selected';
                break;
            default:
                echo '';
        }
    }
}