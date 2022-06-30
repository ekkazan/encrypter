<?php
/**
 * PHP Encrypter class.
 *
 * @author Cem EKKAZAN
 */

class Iterator {
  /**
   * Init Iterator class.
   * 
   * @param string $masterPass
   */
  public function __construct(string $masterPass) {
    $this->setMasterPass($masterPass);
  }

  /**
   * Split a unicode string.
   * 
   * @param mixed $string
   * @param int $length
   * 
   * @return array
   */
  public function splitString(string $string, int $length = 0) {
    if($length > 0) {
      $ret = array();
      $strLength = mb_strlen($string, 'UTF-8');
      for ($i = 0; $i < $strLength; $i += $length) {
        $ret[] = mb_substr($string, $i, $length, 'UTF-8');
      }
        
      return $ret;
    }
  
    return preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
  }

  /**
   * Set master password.
   * 
   * @param mixed $masterPass
   */
  public function setMasterPass(string $masterPass) {
    $splitmasterPass = $this->splitString($masterPass);

    $calcMasterPass = 0;

    foreach($splitmasterPass as $masterChar) {
      $calcMasterPass += ord($masterChar);
    }

    $this->masterPass = $masterPass;
    $this->masterOrder = $calcMasterPass;
  }

  /**
   * Encrypt a data.
   * 
   * @param string $data
   * 
   * @return array
   */
  public function encrypt(string $data) {
    $splitData = $this->splitString($data);

    $ords = [];

    $count = 0;

    foreach($splitData as $char) {
      $add = $this->masterOrder + $count;
      $count++;
      
      $newValue = (ord($char) + $add) % 255;

      array_push($ords, $newValue);
    }

    return $ords;
  }

  /**
   * Decrypt an encrypted data.
   * 
   * @param array $data
   * 
   * @return array
   */
  public function decrypt(array $data) {
    $ords = [];
    
    $count = 0;

    foreach($data as $order => $value) {
      $add = $this->masterOrder + $count;
      $count++;

      $defaultValue = 255 - (($add - $value) % 255);

      array_push($ords, $defaultValue);
    }

    return $ords;
  }
}
