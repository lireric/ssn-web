<?php
include_once 'ssn_db.php';
include_once 'AES.php';

class token {

    protected $token_enc;
    protected $iv;
    protected $key;
    protected $timestamp;
    protected $acc;
    protected $obj;
    protected $cmd;
    protected $data1;
    protected $data2;

    function __construct($token_enc, $acc, $iv) {

       	$this->setTokenEnc($token_enc);
	$this->setTokenIV($iv);
	$this->acc = $acc;

	$ssn_db = new ssn_db();
	$link = $ssn_db->connect_db();
	$ssn_acc_key = $ssn_db->get_key($acc);
        $this->key = $ssn_acc_key;
//printf("\r\nIV:%s", $this->iv);

	$aes = new AES($token_enc, $ssn_acc_key, 128);
//	$aes->setMode(AES::M_ECB);
	$aes->setMode('ecb');
	$aes->setIV($this->iv);
	$token_decrypted = $aes->decrypt();
//printf("\r\nDECRYPTED TOKEN:%s==%x==%x", $token_decrypted,ord($token_decrypted[0]),ord($token_decrypted[15]));

	$this->timestamp = 0+(ord($token_decrypted[3])<<24)+(ord($token_decrypted[2])<<16)+(ord($token_decrypted[1])<<8)+ord($token_decrypted[0]);
	$this->acc = (ord($token_decrypted[5])<<8)+ord($token_decrypted[4]);
	$this->obj = (ord($token_decrypted[7])<<8)+ord($token_decrypted[6]);
	$this->cmd = (ord($token_decrypted[9])<<8)+ord($token_decrypted[8]);
	$this->data2 = (ord($token_decrypted[11])<<8)+ord($token_decrypted[10]);
	$this->data1 = (ord($token_decrypted[15])<<24)+(ord($token_decrypted[14])<<16)+(ord($token_decrypted[13])<<8)+ord($token_decrypted[12]);

//printf("\r\nTIME:%s", date("Y-m-d H:i:s",$this->timestamp));
//printf("\r\nACC:%d", $this->acc);
//printf("\r\nOBJ:%d", $this->obj);
//printf("\r\nCMD:%d", $this->cmd);
//printf("\r\nData1:%d", $this->data1);
//printf("\r\nData2:%d", $this->data2);
    }

    public function setTokenEnc($token_enc) {
	$this->token_enc = $token_enc;
    }

    public function setTokenIV($token_iv) {
	$this->iv = $token_iv;
    }

    public function getTokenBuf() {
	return $token_decrypted;
    }

    public function getTokenData1() {
	return $this->data1;
    }

    public function getTokenData2() {
	return $this->data2;
    }

    public function getTokenCommand() {
	return $this->cmd;
    }

    public function getTokenTimestamp() {
	return $this->timestamp;
    }

    public function getTokenAccount() {
	return $this->acc;
    }

    public function getTokenObject() {
	return $this->obj;
    }

}
