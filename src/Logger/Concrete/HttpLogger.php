<?php

namespace Rpj\Login\Logger\Concrete;

class HttpLogger implements ILoggerHandler
{
    use TFormatter;

    const USER_AGENT = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 14_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.0 Safari/605.1.15';

    private $curl = null;

    public function __construct(
        private string $url,
        private bool $isGetRequest = true,
        private string $dataName = 'data',
    ) {
        $this->curl = curl_init();

        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_FAILONERROR, true);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_USERAGENT, self::USER_AGENT);
    }

    public function handle(array $vars): bool
    {
        $output = $this->formatLog(self::DEFAULT_FORMAT, $vars);
        $data = [$this->dataName => $output];

        if ($this->isGetRequest) {
            $this->url = $this->url.'?'.http_build_query($data);
        } else {
            curl_setopt($this->curl, CURLOPT_POST, true);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, json_encode($data));
        }

        curl_setopt($this->curl, CURLOPT_URL, $this->url);
        curl_exec($this->curl);
        curl_close($this->curl);

        $error = curl_errno($this->curl);

        return $error === 0;
    }
}
