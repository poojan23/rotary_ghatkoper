<?php

class Proxy
{
	private $data = array();

	public function &__get($key)
	{
		return $this->data[$key];
	}

	public function attach($key, &$value)
	{
		$this->data[$key] = $value;
	}

	public function __set($key, $value)
	{
		$this->data[$key] = $value;
	}

	public function __call($method, $args)
	{
		# Hack for pass-by-reference
		foreach ($args as $key => &$value);

		if (isset($this->data[$method])) {
			return call_user_func_array($this->data[$method], $args);
		} else {
			$trace = debug_backtrace();

			exit('<b>Notice</b>:  Undefined property: Proxy::' . $key . ' in <b>' . $trace[1]['file'] . '</b> on line <b>' . $trace[1]['line'] . '</b>');
		}
	}
}
