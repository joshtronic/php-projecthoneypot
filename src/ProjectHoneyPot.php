<?php

/**
 * Project Honey Pot Interface
 *
 * PHP version 5.3+
 *
 * Licensed under The MIT License.
 * Redistribution of these files must retain the above copyright notice.
 *
 * @author    Josh Sherman <hello@joshtronic.com>
 * @copyright Copyright 2012-2015, Josh Sherman
 * @license   http://www.opensource.org/licenses/mit-license.html
 * @link      https://github.com/joshtronic/php-projecthoneypot
 * @link      http://www.projecthoneypot.org/httpbl_configure.php
 */

namespace joshtronic;

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
     * Adds the specified API key to the object.
     *
     * @access public
     * @param  string $api_key PHP API Key (12 characters)
     */
    public function __construct($api_key)
    {
        if (preg_match('/^[a-z]{12}$/', $api_key)) {
            $this->api_key = $api_key;
        } else {
            throw new \Exception('You must specify a valid API key.');
        }
    }

    /**
     * Query
     *
     * Performs a DNS lookup to obtain information about the IP address.
     *
     * @access public
     * @param  string $ip_address IPv4 address to check
     * @return array results from query
     */
    public function query($ip_address)
    {
        // Validates the IP format
        if (filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE)) {
            // Flips the script, err, IP address
            $octets = explode('.', $ip_address);
            krsort($octets);
            $reversed_ip = implode('.', $octets);

            // Performs the query
            $results = $this->dns_get_record($reversed_ip);

            // Processes the results
            if (isset($results[0]['ip'])) {
                $results = explode('.', $results[0]['ip']);

                if ($results[0] == 127) {
                    $results = array(
                        'last_activity' => $results[1],
                        'threat_score'  => $results[2],
                        'categories'    => $results[3],
                    );

                    // Creates an array of categories
                    switch ($results['categories']) {
                        case 0:
                            $categories = array('Search Engine');
                            break;
                        case 1:
                            $categories = array('Suspicious');
                            break;
                        case 2:
                            $categories = array('Harvester');
                            break;
                        case 3:
                            $categories = array('Suspicious', 'Harvester');
                            break;
                        case 4:
                            $categories = array('Comment Spammer');
                            break;
                        case 5:
                            $categories = array('Suspicious', 'Comment Spammer');
                            break;
                        case 6:
                            $categories = array('Harvester', 'Comment Spammer');
                            break;
                        case 7:
                            $categories = array('Suspicious', 'Harvester', 'Comment Spammer');
                            break;
                        default:
                            $categories = array('Reserved for Future Use');
                            break;
                    }

                    $results['categories'] = $categories;

                    return $results;
                }
            }
        } else {
            return array('error' => 'Invalid IP address.');
        }

        return false;
    }

    /**
     * DNS Get Record
     *
     * Wrapper method for dns_get_record() to allow for easy mocking of the
     * results in our tests. Takes an already reversed IP address and does a
     * DNS lookup for A records against the http:BL API.
     *
     * @access public
     * @param  string $reversed_ip reversed IPv4 address to check
     * @return array results from the DNS lookup
     */
    public function dns_get_record($reversed_ip)
    {
        return dns_get_record($this->api_key . '.' . $reversed_ip . '.dnsbl.httpbl.org', DNS_A);
    }
}

