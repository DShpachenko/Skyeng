<?php

namespace App\Helpers;

use App\Exceptions\HttpCurlException;

/**
 * Class HttpCurl
 * @package App\Helpers
 */
class HttpCurl
{
    protected $host;
    protected $user;
    protected $password;

    /**
     * HttpCurl constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->host = $config['host'];
        $this->user = $config['user'];
        $this->password = $config['password'];
    }

    /**
     * @param array $request
     * @return array|null
     * @throws HttpCurlException
     */
    public function get(array $request): ? array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->host . '?' . http_build_query($request));
        curl_setopt($ch, CURLOPT_USERPWD, $this->user . ":" . $this->password);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);

        if(curl_errno($ch)){
            throw new HttpCurlException(curl_error($ch));
        }
        curl_close($ch);

        return json_decode($output, true);
    }
}