<?php
/**
 * Created by PhpStorm.
 * User: gabry
 * Date: 15.09.2018
 * Time: 14:26
 */

namespace App\Utils;

class UniqueCode {

    /**
     * Generate unique codes without duplicates
     * @param int $lenght
     * @return bool|string
     * @throws \Exception
     */
    public function real(int $lenght = 8): string {
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
     * @throws \Exception
     */
    public function generateArray(int $length = 10): array {
        $codes_array = [];

        for($i=0; $i<$length; $i++)
            array_push($codes_array, [
                "value"=>$this->real(),
                "date_create"=> new \DateTime("now")]
            );
        return $codes_array;
    }

}