<?php
class CheckPasswordComplexity
{
  
    function checkPassword($password)
    {
        $strength = ['Excellent', 'Strong', 'Good', 'Week'];

        if ($this->isEnoughLength($password, 12) && $this->containsMixedCase($password) && $this->containsDigits($password) && $this->containsSpecialChars($password)) {
            return $strength[0];
        } elseif ($this->isEnoughLength($password, 10) && $this->containsMixedCase($password) && $this->containsDigits($password)) {
            return $strength[1];
        } elseif ($this->isEnoughLength($password, 8) && $this->containsMixedCase($password)) {
            return $strength[2];
        } elseif ($this->isEnoughLength($password, 8) && $this->containsDigits($password)) {
            return $strength[2];
        } elseif ($this->isEnoughLength($password, 8) && $this->containsSpecialChars($password)) {
            return $strength[2];
        } else {
            return $strength[3];
        }
    }


    private function isEnoughLength($password, $length)
    {
        if (empty($password)) {
            return false;
        } elseif (strlen($password) < $length) {
            return false;
        } else {
            return true;
        }
    }


    private function containsMixedCase($password)
    {
        if (preg_match('/[a-z]+/', $password) && preg_match('/[A-Z]+/', $password)) {
            return true;
        } else {
            return false;
        }
    }

    
    private function containsDigits($password)
    {
        if (preg_match("/\d/", $password)) {
            return true;
        } else {
            return false;
        }
    }

 
    private function containsSpecialChars($password)
    {
        if (preg_match("/[^\da-z]/", $password)) {
            return true;
        } else {
            return false;
        }
    }
}