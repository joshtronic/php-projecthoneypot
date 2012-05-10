<?php

class ProjectHoneyPot
{
	private $api_key = '';

	public function __construct($api_key)
	{
		if (preg_match('/^[a-z]{12}$/', $api_key))
		{
			$this->api_key = $api_key;
		}
		else
		{
			throw new Exception('Y U No Supply Valid API Key?!');
		}
	}

	public function query($ip_address)
	{
		if (filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE))
		{
			// Flip tha script
			$octets = explode('.', $ip_address);
			krsort($octets);
			$reversed_ip = implode('.', $octets);

			$results = dns_get_record($this->api_key . '.' . $reversed_ip . '.dnsbl.httpbl.org');
			$results = explode('.', $results);

			if ($results[0] == 127)
			{
				$last_activity = $results[1];
				$threat_sore   = $results[2];
			}
		}

		return array('error' => 'Invalid IP Address');
	}
}

?>
