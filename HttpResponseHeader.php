<?php

declare(strict_types=1);

namespace myth21\component;

/**
 * Class HttpResponseHeader
 * @package myth21\component
 */
class HttpResponseHeader
{
    private string $url;
    private array $headers = [];

    protected int $format = 1;

    public function __construct(string $url, $isErrorSuppress = true)
    {
        $this->url = $url;
        $this->headers = $this->getHeaders($isErrorSuppress);
    }

    protected function getHeaders($isErrorSuppress): array
    {
        $context = stream_context_create([
                                             'http' => [
                                                 'method' => 'HEAD',
                                                 'ignore_errors' => true,
                                             ]
                                         ]);

        $headers = $isErrorSuppress
            ? @get_headers($this->url, $this->format, $context)
            : get_headers($this->url, $this->format, $context);

        if (is_array($headers)) {
            $this->headers = $headers;
        }

        return $this->headers;
    }

    public function getCode(): ?string
    {
        if (isset($this->headers[0])) {
            // headers[0] is `HTTP/1.1 200 OK`
            return substr($this->headers[0], 9, 3);
        }

        return null;
    }

    public function isOkCode(): bool
    {
        return $this->getCode() === '200';
    }
}