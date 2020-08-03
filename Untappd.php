<?php

/**
 * Untappd class
 * 
 * @copyright 2020 Willem den Hertog (willem.denhertog@gmail.com)
 * 
 */
class Untappd
{

	private $clientId;

	private $clientSecret;

	private $baseUrl = "https://api.untappd.com/v4";

	private $userAgent = "Willem's Bierenlijst";

	/**
	 * Constructor
	 *
	 * @param string $client_id
	 * @param string $client_secret
	 */
	public function __construct($client_id, $client_secret)
	{
		$this->clientId = $client_id;
		$this->clientSecret = $client_secret;
		$this->userAgent .= " ($this->clientId)";
	}

	public function get($url, $params = array())
	{
		$query = "";

		if (sizeof($params) != 0) {
			$query = "&" . http_build_query($params);
		}

		$url = $this->baseUrl . $url . "?client_id=" . $this->clientId . "&client_secret=" . $this->clientSecret . $query;

		$response = $this->call($url, 'GET', $params);

		return json_decode($response);
	}

	private function call($url, $method, $params)
	{
		$curl = curl_init($url);

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);

		$result = curl_exec($curl);

		return $result;
	}
}
?>