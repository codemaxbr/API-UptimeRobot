<?php 
namespace UptimeRobot;

trait UptimeFunctions{

	public function getMonitors($host = ''){
		if(empty($host)){
			return $this->request('/getMonitors', []);
		}else{
			$args = array(
				'monitors' => $host
			);

			return $this->request('/getMonitors', $args);
		}
	}

	public function getMonitorURL($host = ''){
		if(empty($host)){
			return $this->request('/getMonitors', []);
		}else{
			$args = array(
				'search' => $host
			);

			return $this->request('/getMonitors', $args);
		}
	}

	public function getUptime($id = ''){
		if(empty($id)){
			throw new Exception("Id Host é obrigatório", 1);
		}

		$result = $this->request('/getMonitors', ['monitors' => $id]);
		return (object) array('uptime' => $result->monitors->monitor[0]->alltimeuptimeratio."%", 'status' => $result->monitors->monitor[0]->status);
	}

	public function newMonitor($param = null){
		if(empty($param) || !is_array($param))
		{
			throw new Exception("Parâmetros inválidos.", 1);
		}

		if(!isset($param['name']) || empty($param['name']))
		{
			throw new Exception("O campo 'name' é obrigatório.", 1);
		}

		if(!isset($param['host']) || empty($param['host']))
		{
			throw new Exception("O campo 'Host' é obrigatório.", 1);
		}

		$args = [
	        'apiKey' => $this->getApiKey(),
	        'monitorFriendlyName' => $param['name'],
	        'monitorURL' => $param['host'],
	        'monitorType' => 1,
	        'monitorSubType' => 1,
	    ];

	    return $this->request('/newMonitor', $args);
	}
}