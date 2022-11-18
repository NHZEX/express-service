<?php

namespace Zxin\Express\SeventeenTrack;

use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use function is_array;
use function json_decode;

class ApiClient
{
    private string $token;

    private ?Client $client = null;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        if (null !== $this->client) {
            return $this->client;
        }

        $options = [
            'base_uri'              => 'https://api.17track.net',
            RequestOptions::TIMEOUT => 30.0,
            RequestOptions::VERIFY  => CaBundle::getSystemCaRootBundlePath(),
            RequestOptions::HEADERS => [
                // 'Content-Type'    => 'application/json',
                'Accept-Encoding' => 'gzip, deflate',
                '17token'         => $this->token,
            ],
            RequestOptions::DEBUG   => false,
        ];
        return $this->client = new Client($options);
    }

    public function post(string $url, array $params): array
    {
        $resp = $this
            ->getClient()
            ->post($url, [
                RequestOptions::JSON => $params
            ]);

        $body = $resp->getBody()->getContents();

        $result = json_decode($body, true, 512, JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR);
        $this->checkError($url, $result);

        return $result;
    }

    protected function checkError(string $url, $result)
    {
        if (!is_array($result)) {
            throw new SeventeenRequestException(
                "body invalid ({$url})",
            );
        }
        if (!empty($result['code'])) {
            throw new SeventeenRequestException(
                "error code {$result['code']} ({$url})",
            );
        }

    }
}
