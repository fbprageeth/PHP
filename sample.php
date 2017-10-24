<?php
        \Fuel\Core\Config::load('keys');
        //\Fuel\Core\Config::load('sudatest');
        $encrykey = \Config::get('encry');
        //$test = new Crypt;
        
        //$suda = $test::encryptAes128('Prageeth Sudarshana', 'jgX69ghjeBNBl01FT609Xvr46hKUD5jg8jppPo0O');

        //$test = new Testclass;

        $into = \Securecrypt::encryptAes128('Prageeth Sudarshana', $encrykey);
        $out  = \Securecrypt::decryptAes128($into, $encrykey);

         echo $into.'<br>';
         echo $out.'<br>';


?>
