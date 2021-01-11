<?php

declare(strict_types=1);

namespace myth21\component;

/**
 * Class HttpResponse
 * @package myth21\component
 */
class HttpResponse
{
    private string $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return false|string
     */
    public function getCode()
    {
        stream_context_set_default([
            'http' => [
                'method' => 'HEAD'
            ]
        ]);

        try {

            $headers = get_headers($this->url); // throws ErrorException when url is not corrects
            if (is_array($headers) && isset($headers[0])) {

                return substr($headers[0], 9, 3); // $headers[0] is `HTTP/1.1 200 OK`
            }

        } catch (\Throwable $e) {
            // Handle please
        }

        return false;
    }

    public function isOkCode(): bool
    {
        return $this->getCode() === '200';
    }
}