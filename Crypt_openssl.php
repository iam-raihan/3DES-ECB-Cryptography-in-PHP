<?php
/**
 * Created by PhpStorm.
 * User: Raihan
 * Date: 10-Jul-17
 * Time: 4:37 AM
 */

class CryptOpenssl{
    private $hash;

    function __construct($hash){
        $key = md5($hash,TRUE);
        $key .= substr($key,0,8);
        $this->hash = $key;
    }

    /**
     * @param $data
     * @return string
     */
    public function Encrypt($data){
        $encData = openssl_encrypt($data, 'DES-EDE3', $this->hash, OPENSSL_RAW_DATA);

        $encData = base64_encode($encData);

        return $encData;
    }

    /**
     * @param $data
     * @return string
     */
    public function Decrypt($data){
        $data = base64_decode($data);

        $decData = openssl_decrypt($data, 'DES-EDE3', $this->hash, OPENSSL_RAW_DATA);

        return $decData;
    }
}