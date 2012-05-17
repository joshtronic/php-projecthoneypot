<?php

/**
 * Project Honey Pot Class
 *
 * @author Josh Sherman
 * @link   http://github.com/joshtronic/php-projecthoneypot
 * @link   http://www.projecthoneypot.org/httpbl_configure.php
 */
class ProjectHoneyPot
{
	/**
	 * API Key
	 *
	 * @access private
	 * @var    string
	 */
	private $api_key = '';

	/**
	 * Constructor
	 *
	 * @param string $api_key PHP API Key (12 characters)
	 */
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

	/**
	 * Query API
	 *
	 * @param string $ip_address IPv4 address to check
	 * @return array results from query
	 */
	public function query($ip_address)
	{
		// Validate the IP format
		if (filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE))
		{
			// Flip tha script
			$octets = explode('.', $ip_address);
			krsort($octets);
			$reversed_ip = implode('.', $octets);

			// Perform the query
			$results = dns_get_record($this->api_key . '.' . $reversed_ip . '.dnsbl.httpbl.org', DNS_A);

			// Process the results
			if (isset($results[0]['ip']))
			{
				$results = explode('.', $results[0]['ip']);

				if ($results[0] == 127)
				{
					$results = array(
						'last_activity' => $results[1],
						'threat_score'  => $results[2],
						'categories'    => $results[3],
					);

					// Creates an array of categories
					switch ($results['categories'])
					{
						case 0:  $results['categories'] = array('Search Engine');                              break;
						case 1:  $results['categories'] = array('Suspicious');                                 break;
						case 2:  $results['categories'] = array('Harvester');                                  break;
						case 3:  $results['categories'] = array('Suspicious', 'Harvester');                    break;
						case 4:  $results['categories'] = array('Comment Spammer');                            break;
						case 5:  $results['categories'] = array('Suspicious', 'Comment Spammer');              break;
						case 6:  $results['categories'] = array('Harvester', 'Comment Spammer');               break;
						case 7:  $results['categories'] = array('Suspicious', 'Harvester', 'Comment Spammer'); break;
						default: $results['categories'] = array('Reserved for Future Use');                    break;
					}

					return $results;
				}
			}
			else
			{
				return false;
			}
		}

		return array('error' => 'Invalid IP Address');
	}
}

?>
