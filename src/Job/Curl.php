<?php

namespace Etmp\Job;

class Curl {
    private $handle;

    /**
     * Constructs a curl instance, sets the basic options.
     *
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->handle = curl_init();
        curl_setopt($this->handle, CURLOPT_URL, $url);
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, true);
    }

    /**
     * Sets a specified option.
     *
     * @param  int   $option
     * @param  mixed $value
     * @return void
     */
    public function setOption(int $option, $value)
    {
        curl_setopt($this->handle, $option, $value);
    }

    /**
     * Sets a base64 authentication curl option with the
     * given authentication details.
     *
     * @param  string $username
     * @param  string $password
     * @return void
     */
    public function setAuthentication(string $username, string $password)
    {
        curl_setopt($this->handle, CURLOPT_USERPWD, $username . ':' . $password);
    }

    /**
     * Executes the curl instance and returns a status of true or false.
     *
     * @return bool
     */
    public function execute()
    {
        $this->response   = curl_exec($this->handle);
        $this->statusCode = curl_getinfo($this->handle, CURLINFO_HTTP_CODE); 
        curl_close($this->handle);

        return $this->statusCode >= 200 && $this->statusCode < 400;
    }

    /**
     * Returns status code and message if this curl
     * instance is used as a string.
     *
     * @param  Etmp\Render\Message $message
     * @return void
     */
    public function __toString()
    {
        return $this->statusCode . ' ' . $this->response;
    }
}