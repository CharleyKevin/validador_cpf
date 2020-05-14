<?php


namespace App\Services;


class ValidateCPFService
{
    public function __construct(string $cpf)
    {
        $this->cpf = $cpf;
    }

    public function isValid()
    {
        $cpf = $this->cpf;
        $isValid = true;

        if (empty($cpf)) {
            return false;
        }
        if (!is_numeric($cpf)) {
            return false;
        }
        if (strlen($cpf) != 11) {
            return false;
        }

        $repeatedDigitChecker = floor(log10($cpf)) + 1;

        if (is_int($cpf / str_repeat(1,$repeatedDigitChecker))){
            return false;
        }

        $digitChecker = 10;
        while($digitChecker <= 11) {

            for ($i=0; $i<$digitChecker-1; $i++) {
                $multiply[$i] = $cpf[$i]*$digitChecker;
                $digitChecker--;
            }
            $sum = array_sum($multiply);
            $rest = $sum%11;
            if($rest<2) {
                $digit = 0;
            }else {
                $digit = 11 - $rest;
            }
            if ($digit != $cpf[$digitChecker-1]) {
                $isValid = false;
            }
            $digitChecker++;
        }

        return  $isValid;

    }

}
