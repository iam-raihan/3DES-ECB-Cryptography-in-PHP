<?php
/**
 * Created by PhpStorm.
 * User: Raihan
 * Date: 10-Jul-17
 * Time: 3:50 AM
 */

require_once 'Crypt_mcrypt.php';
require_once 'Crypt_openssl.php';

if (!empty($_POST["hash"])) {
    $hash = $_POST["hash"];
    echo "Hash = <b>{$hash}</b>";
    $crypt_mcrypt = new CryptMcrypt($hash);
    $crypt_openssl = new CryptOpenssl($hash);

    if (!empty($_POST["data"])) {
        $data = $_POST["data"];
        echo "<br/>Data = <b>{$data}</b>";
        echo "<br/>Option Selected = <b>{$_POST["option"]}</b><br/>";

        if ($_POST["option"] == "encrypt") {
            //using mcrypt
            $start_time = microtime(true);
            $result = $crypt_mcrypt->Encrypt($data);
            $stop_time = microtime(true);
            $time_mcrypt = $stop_time - $start_time;
            //using openssl
            $start_time = microtime(true);
            $result = $crypt_openssl->Encrypt($data);
            $stop_time = microtime(true);
            $time_openssl = $stop_time - $start_time;

            CheckResult($result);
            echo "<br/>Encrypted data = <b>{$result}</b>";

            ShotTime($time_mcrypt,$time_openssl);

//            $test_result = $crypt_openssl->Decrypt($result);
//            echo "<br/>Test Result = <b>{$test_result}</b>";
        }

        if ($_POST["option"] == "decrypt") {
            //using mcrypt
            $start_time = microtime(true);
            $result = $crypt_mcrypt->Decrypt($data);
            $stop_time = microtime(true);
            $time_mcrypt = $stop_time - $start_time;
            //using openssl
            $result = $crypt_openssl->Decrypt($data);
            $stop_time = microtime(true);
            $time_openssl = $stop_time - $start_time;

            CheckResult($result);
            $start_time = microtime(true);
            echo "<br/>Decrypted data = <b>{$result}</b>";

            ShotTime($time_mcrypt,$time_openssl);

//            $test_result = $crypt_openssl->Encrypt($result);
//            echo "<br/>Test Result = <b>{$test_result}</b>";
        }
    } else {
        throw new Exception("{{ Data missing }}");
    }
} else {
    throw new Exception("{{ Hash missing }}");
}

function CheckResult($result) {
    if ($result == "" || $result == false) {
        throw new Exception("{{ Invalid Data }}");
    }
}

function ShotTime($time_mcrypt, $time_openssl)
{
    echo "<br/>Time (mcrypt) :{$time_mcrypt} ms";
    echo "<br/>Time (openssl) :{$time_openssl} ms";
}