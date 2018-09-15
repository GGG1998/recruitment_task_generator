<?php
/**
 * Created by PhpStorm.
 * User: gabry
 * Date: 15.09.2018
 * Time: 14:26
 */

class UniqueCode {

    /**
     * Generate unique codes without duplicates
     * @param int $lenght
     * @return bool|string
     * @throws Exception
     */
    public function uniqidReal($lenght = 8) {
        // uniqid gives 8 chars, but you could adjust it to your needs.
        if (function_exists("random_bytes"))
            $bytes = random_bytes(ceil($lenght / 2));
        elseif (function_exists("openssl_random_pseudo_bytes"))
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        else
            throw new Exception("no cryptographically secure random function available");
        return substr(bin2hex($bytes), 0, $lenght);
    }

    /**
     * Generate array of unique codes
     * @param int $length
     * @return array
     */
    public function generateArrayUniqid($length = 10) {
        $codes_array = [];

        for($i=0; $i<$length; $i++)
            array_push($codes_array);
        return $codes_array;
    }

}