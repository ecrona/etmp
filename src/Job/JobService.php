<?php

namespace Etmp\Job;

use Exception;

class JobService {
    public $curlUrl = 'https://dynupdate.no-ip.com/nic/update?hostname=%s&myip=%s';

    public function fetchAdress(string $url): string
    {
        $adress = @file_get_contents($url);

        if ($adress === false) {
            throw new Exception('Could not fetch adress');
        }

        return $adress;
    }

    public function setAdress(
        string $adress,
        string $hostname,
        string $username,
        string $password
    ): string {
        $curl = new Curl(sprintf(
            $this->curlUrl,
            $hostname,
            $adress
        ));
        
        $curl->setAuthentication($username, $password);

        if (!$curl->execute()) {
            throw new Exception($curl);
        }

        return (string) $curl;
    }
}