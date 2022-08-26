<?php
class Parameters
{
	var $params;
	
	/*
	 * param : string or array
	 * string : get from database
	 * array: load direct
	 */
	function __construct($params = '',$type = 'string')
	{
		if($type == 'string'){
			$value = explode(chr(13),$params);
			$array_params = array();
			foreach ($value as $item)
			{
				$buff = explode('=',$item);
				if(count($buff)> 2){
					$buff_2 = substr($item, strpos($item, '=') + 2, -1);
					$array_params[trim(@$buff[0])]= '"'.$buff_2.'"';
				}else{
					$array_params[trim(@$buff[0])]= @$buff[1];
				}
			
				
			}
			$this->params = $array_params;
		} else {
			$this->params = $params;
		}
	}
	
	function getParams($name)
	{
		$array_params = $this->params;
		if(isset($array_params["$name"])){
			return @$array_params["$name"];
		}
		else{
			return ;
		}
	}
}