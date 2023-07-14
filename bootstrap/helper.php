<?php

if(!function_exists("generateLithuanianIBAN")){

    function generateLithuanianIBAN() {
        $countryCode = 'LT';
        $bankAccountNumber = sprintf('%014d', mt_rand(0, 99999999999999));
    
        $iban = $countryCode . '00' . $bankAccountNumber;
    
        // Calculate the checksum digits
        $ibanDigits = str_split($iban);
        $checksum = 0;

        foreach ($ibanDigits as $digit) {
            $checksum = ($checksum * 10 + intval($digit)) % 97;
        }
        $checksumDigits = sprintf('%02d', 98 - $checksum);
    
        // Replace the placeholder checksum with the calculated checksum digits
        $iban = substr_replace($iban, $checksumDigits, 2, 2);
    
        return $iban;
    }
}


