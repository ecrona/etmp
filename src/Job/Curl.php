<?php

namespace Etmp\Job;

class Curl {
    private $handle;

    public function __construct(string $url)
    {
        $this->handle = curl_init();
        curl_setopt($this->handle, CURLOPT_URL, $url);
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
    }

    public function setOption(int $option, $value)
    {
        curl_setopt($this->handle, $option, $value);
    }

    public function setAuthentication(string $username, string $password)
    {
        curl_setopt($this->handle, CURLOPT_USERPWD, $username . ':' . $password);
    }

    public function execute()
    {
        $this->response   = curl_exec($this->handle);
        $this->statusCode = curl_getinfo($this->handle, CURLINFO_HTTP_CODE); 
        curl_close($this->handle);

        return $this->statusCode >= 200 && $this->statusCode < 400;
    }

    public function __toString()
    {
        return $this->statusCode . ' ' . $this->response;
    }
}