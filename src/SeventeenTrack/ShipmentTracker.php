<?php
declare(strict_types=1);

namespace Zxin\Express\SeventeenTrack;

use Zxin\Express\TrackEventAdapter;
use Zxin\Express\SeventeenTrack\Params\QueryTrackInfo;
use Zxin\Express\SeventeenTrack\Params\RegisterTrack;
use Zxin\Express\SeventeenTrack\Params\TrackInfo;
use function array_values;
use function count;
use function var_dump;

class ShipmentTracker
{
    private ApiClient $api;

    public function __construct(string $token)
    {
        $this->api = new ApiClient($token);
    }

    public function getQuota(): array
    {
        $result = $this->api->post('track/v2/getquota', []);

        return $result['data'];
    }

    public function register(
        string  $trackNumber,
        int     $carrier,
        ?string $tag = null
    ): RegisterTrack {
        $track = new RegisterTrack($trackNumber, $carrier, $tag);
        $data  = $this->registerMulti([
            $track,
        ]);

        return $data[0];
    }

    /**
     * @param array<RegisterTrack> $trackNumbers
     * @return array<RegisterTrack>
     */
    public function registerMulti(array $trackNumbers): array
    {
        if (count($trackNumbers) > 40) {
            throw new \InvalidArgumentException('单次请求最多40个单号');
        }

        $result = $this->api->post('track/v2/register', $trackNumbers);
        $data   = $result['data'];

        $mapping = [];
        foreach ($trackNumbers as $params) {
            $mapping[$params->getNumber()] = clone $params;
        }

        foreach ($data['accepted'] ?? [] as $item) {
            $params = $mapping[$item['number']] ?? null;
            if (null === $params) {
                throw new SeventeenRequestException(
                    "Unexpected value {$item['number']} [register]"
                );
            }

            $params->setRegister(true);
            $params->setOrigin($item['origin']);
        }

        foreach ($data['rejected'] ?? [] as $item) {
            $params = $mapping[$item['number']] ?? null;
            if (null === $params) {
                throw new SeventeenRequestException(
                    "Unexpected value {$item['number']} [register]"
                );
            }
            $params->setErrorInfo($item['error']['code'], $item['error']['message']);
            if ($params->getErrorCode() === -18019901) {
                $params->setRegister(true);
            }
        }

        return array_values($mapping);
    }

    public function getTrackInfo(string $trackNumber, int $carrier): QueryTrackInfo
    {
        $track = new QueryTrackInfo($trackNumber);
        $track->setCarrier($carrier);
        $data = $this->getTrackInfoMulti([
            $track,
        ]);

        return $data[0];
    }

    /**
     * @param array<QueryTrackInfo> $trackNumbers
     * @return array<QueryTrackInfo>
     */
    public function getTrackInfoMulti(array $trackNumbers): array
    {
        if (count($trackNumbers) > 40) {
            throw new \InvalidArgumentException('单次请求最多40个单号');
        }

        $result = $this->api->post('track/v2/gettrackinfo', $trackNumbers);

        $data = $result['data'];

        $mapping = [];
        foreach ($trackNumbers as $params) {
            $mapping[$params->getNumber()] = clone $params;
        }

        $trackList = [];
        foreach ($data['accepted'] ?? [] as $item) {
            $params = $mapping[$item['number']] ?? null;
            if (null === $params) {
                throw new SeventeenRequestException(
                    "Unexpected value {$item['number']} [track info]"
                );
            }

            $params->setCarrier($item['carrier']);
            $params->setParam($item['param']);
            $params->setTag($item['tag']);
            $params->setTrackInfo($item['track_info']);
            $trackList[] = $params;
        }
        foreach ($data['rejected'] ?? [] as $item) {
            $params = $mapping[$item['number']] ?? null;
            if (null === $params) {
                throw new SeventeenRequestException(
                    "Unexpected value {$item['number']} [track info]"
                );
            }

            $params->setErrorInfo($item['error']['code'], $item['error']['message']);
            $trackList[] = $params;
        }

        return $trackList;
    }
}
