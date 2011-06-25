<?php defined('SYSPATH') or die('No direct script access.');

class Log_Everlog extends Log_Writer {
	var $everlog;

	public function __construct()
	{
		$this->everlog = new Everlog;
	}

	public function write(array $messages)
	{
		foreach($messages as $message)
		{
			$this->everlog->call('dp/log', NULL, 'PUT', 
					array( 
							'value'=> $this->_log_levels[$message['level']].': '.$message['body'], 
							'created' => $message['time'],
							)
					);
		}
	}
}
