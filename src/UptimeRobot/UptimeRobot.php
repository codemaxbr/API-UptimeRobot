<?php
namespace UptimeRobot;

/**
 * Class API
 * @package UptimeRobot
 */
class UptimeRobot{
    use UptimeFunctions;

    private $url = 'http://api.uptimerobot.com';
    private $contents;

    private $args;
    private $options;

    public $debug;

    public function __construct($apiKey = ''){
        if (empty($apiKey)) {
            throw new Exception('Chave API não configurada.');
        }

        $this->config($apiKey);
        $this->options = $this->getOptions($options);
    }

    /**
     * Set your API key
     * 
     * @param string $key               require   Set your main API Key or Monitor-Specific API Keys (only getMonitors)
     * @param bool   $noJsonCallback    optional  Define if the function wrapper to be removed
     * 
     */
    private function config($key, $noJsonCallback = 1)
    {
        if (empty($key)) {
            throw new Exception('Chave API não configurada.');
        }

        $this->args['apiKey'] = $key;
        $this->args['format'] = 'json';
        $this->args['noJsonCallback'] = $noJsonCallback;
    }

    /**
     * Returns the API key
     * 
     */
    public function getApiKey()
    {
        if (empty($this->args['apiKey']))
        {
            throw new Exception('Chave API não configurada.', 1);
        }
        return $this->args['apiKey'];
    }

    /**
     * Makes curl call to the url & returns output.
     *
     * @param string $resource The resource of the api
     * @param array $args Array of options for the query query
     *
     * @return array json_decoded contents
     * @throws \Exception If the curl request fails
     */
    public function request($resource, $args = array())
    {

        $url = $this->buildUrl($resource, $args);
        $curl = curl_init($url);

        curl_setopt_array($curl, $this->options);
        $this->contents = curl_exec($curl);
        $this->setDebug($curl);

        if (curl_errno($curl) > 0) {
            throw new \Exception('Ocorreu um erro ao fazer o pedido.');
        }

        return json_decode($this->contents);
    }

    /**
     * Get options for curl.
     *
     * @param $options
     *
     * @return array
     */
    private function getOptions($options)
    {
        $conf = [
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
        ];

        if (isset($options['timeout'])) {
            $conf[CURLOPT_TIMEOUT_MS] = $options['timeout'] * 1000;
        }
        if (isset($options['connect_timeout'])) {
            $conf[CURLOPT_CONNECTTIMEOUT_MS] = $options['connect_timeout'] * 1000;
        }

        return $conf;
    }

    /**
     * Builds the url for the curl request.
     *
     * @param string $resource The resource of the api
     * @param array $args Array of options for the query query
     *
     * @return string  Finalized Url
     */
    private function buildUrl($resource, $args)
    {
        //Merge args(apiKey, Format, noJsonCallback)
        $args = array_merge($args, $this->args);
        $query = http_build_query($args);

        $url = $this->url;
        $url .= $resource . '?' . $query;

        return $url;
    }

    /**
     * Sets debug information from last curl.
     *
     * @param resource $curl Curl handle
     */
    private function setDebug($curl)
    {
        $this->debug = [
            'errorNum' => curl_errno($curl),
            'error' => curl_error($curl),
            'info' => curl_getinfo($curl),
            'raw' => $this->contents,
        ];
    }
}
