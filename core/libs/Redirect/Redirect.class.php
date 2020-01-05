<?php

class Redirect extends TanboRoot {
	public $url;
	public $status;

	function __construct($url, $status) {
		$this->url = $url;
		$this->status = $status;
	}

	function execute() {
		header("Location: " . $this->url, true, $this->status);
		exit;
	}
}