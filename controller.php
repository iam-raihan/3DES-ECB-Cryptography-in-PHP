<?php
/**
 * Created by PhpStorm.
 * User: Raihan
 * Date: 10-Jul-17
 * Time: 3:50 AM
 */

require_once <<<'include'
Crypt.php
include;

if (!empty($_POST["hash"])) {
    $hash = $_POST["hash"];
    echo "Hash = <b>{$hash}</b>";
    $crypt = new Crypt($hash);

    if (!empty($_POST["data"])) {
        $data = $_POST["data"];
        echo "<br/>Data = <b>{$data}</b>";
        echo "<br/>Option Selected = <b>{$_POST["option"]}</b><br/>";

        if ($_POST["option"] == "encrypt") {
            $result = $crypt->Encrypt($data);
            CheckResult($result);
            echo "<br/>Encrypted data = <b>{$result}</b>";
            $test_result = $crypt->Decrypt($result);
            echo "<br/>Test Result = <b>{$test_result}</b>";
        }

        if ($_POST["option"] == "decrypt") {
            $result = $crypt->Decrypt($data);
            CheckResult($result);
            echo "<br/>Decrypted data = <b>{$result}</b>";
            $test_result = $crypt->Encrypt($result);
            echo "<br/>Test Result = <b>{$test_result}</b>";
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