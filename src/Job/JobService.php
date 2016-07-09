<?php

namespace Etmp\Job;

use Exception;

class JobService {
    public $curlUrl = 'https://dynupdate.no-ip.com/nic/update?hostname=%s&myip=%s';

    /**
     * Fetches an adress through an assigned adress.
     *
     * @param  string $url
     * @return string
     */
    public function fetchAdress(string $url): string
    {
        $adress = @file_get_contents($url);

        if ($adress === false) {
            throw new Exception('Could not fetch adress');
        }

        return $adress;
    }

    /**
     * Sets the adress through a curl request using a
     * static url with assigned properties.
     *
     * @param  string $adress
     * @param  string $domain
     * @param  string $username
     * @param  string $password
     * @return string
     */
    public function setAdress(
        string $adress,
        string $domain,
        string $username,
        string $password
    ): string {
        $curl = new Curl(sprintf(
            $this->curlUrl,
            $domain,
            $adress
        ));
        
        $curl->setAuthentication($username, $password);

        if (!$curl->execute()) {
            throw new Exception($curl);
        }

        return (string) $curl;
    }
}