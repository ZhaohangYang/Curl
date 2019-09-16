<?php
namespace huoban\helpers;

use huoban\helpers\CurlHttp;


class Huoban {

	private $ticket = '';
	private $table_id = '';
	
	//初始化
	public function __construct($ticket) {        
		CurlHttp::setup($ticket, IS_TEST);
	}

	public function setTicket($ticket) {
		$this->ticket = $ticket;
	}

	public function getTicket() {
		return $this->ticket;
	}

	public function setTableId($table_id) {
		$this->table_id = $table_id;
	}

	public function getTableId() {
		return $this->table_id;
	}

    public function setAppId($app_id) {
        $this->app_id = $app_id;
    }

    public function getAppId() {
        return $this->app_id;
    }
}
