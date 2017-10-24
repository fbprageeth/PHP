<?php
/**
 * 暗号／複合ユーティリティ
 *
 * @author tawatanabe
 */
class Securecrypt {


    public static function encryptAes128($value, $password)
    {
        // Set a random salt
        $salt = openssl_random_pseudo_bytes(16);

        $salted = '';
        $dx = '';
        // Salt the key(32) and iv(16) = 48
        while (strlen($salted) < 48) {
            $dx = hash('sha256', $dx.$password.$salt, true);
            $salted .= $dx;
        }

        $key = substr($salted, 0, 32);
        $iv  = substr($salted, 32,16);

        $encrypted_data = openssl_encrypt($value, 'AES-128-CBC', $key, true, $iv);
        return base64_encode($salt . $encrypted_data);
    }

    /**
     * 暗号キーを指定して暗号済みデータを複合する (AES-128-CBC版)
     *
     * @param mixed $input
     * @param string $key
     * @return string
     */
    public static function decryptAes128($value, $password)
    {
        $data = base64_decode($value);
        $salt = substr($data, 0, 16);
        $ct = substr($data, 16);

        $rounds = 3; // depends on key length
        $data00 = $password.$salt;
        $hash = array();
        $hash[0] = hash('sha256', $data00, true);
        $result = $hash[0];
        for ($i = 1; $i < $rounds; $i++) {
            $hash[$i] = hash('sha256', $hash[$i - 1].$data00, true);
            $result .= $hash[$i];
        }
        $key = substr($result, 0, 32);
        $iv  = substr($result, 32,16);

        return openssl_decrypt($ct, 'AES-128-CBC', $key, true, $iv);
    }

}
