<?php
/**
 * Created by PhpStorm.
 * User: Raihan
 * Date: 10-Jul-17
 * Time: 12:48 AM
 */

class CryptMcrypt{
    private $hash;

    function __construct($hash){
        $key = md5($hash,TRUE);
        $key .= substr($key,0,8);
        $this->hash = $key;
    }

    private function pkcs5_pad($data){
        //Pad for PKCS5
        $blockSize = mcrypt_get_block_size('tripledes', 'ecb');
        $len = strlen($data);
        $pad = $blockSize - ($len % $blockSize);
        $data .= str_repeat(chr($pad), $pad);
        return $data;
    }

    private function pkcs5_unpad($data){
        //Unpad for PKCS5
        $pad = ord($data{strlen($data)-1});
        if ($pad > strlen($data)) return false;
        if (strspn($data, chr($pad), strlen($data) - $pad) != $pad) return false;
        return substr($data, 0, -1 * $pad);
    }

    /**
     * @param $data
     * @return string
     */
    public function Encrypt($data){
        $data = $this->pkcs5_pad($data);

        $encData = mcrypt_encrypt('tripledes', $this->hash , $data, 'ecb');

        return base64_encode($encData);
    }

    /**
     * @param $data
     * @return bool|string
     */
    public function Decrypt($data){
        $data = base64_decode($data);

        $data = mcrypt_decrypt('tripledes', $this->hash, $data, 'ecb');

        return $this->pkcs5_unpad($data);
    }
}