<?php
namespace app\modules\olxparser\exceptions;
use Exception;

class OlxException extends Exception {
	public $code;
	public $message;
	public $output;

	public function __construct($code, $message = "", $output = "") {
		$this->code = $code;
		$this->output = $output;

		parent::__construct($message);
	}
}