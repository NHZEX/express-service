<?php

namespace Zxin\Express\SeventeenTrack;

use Zxin\Express\TrackEventAdapter;
use Zxin\Express\SeventeenTrack\Params\QueryTrackInfo;
use Zxin\Express\SeventeenTrack\Params\RegisterTrack;
use Zxin\Express\SeventeenTrack\Params\TrackInfo;
use function array_values;
use function count;

class ShipmentTracker
{
    private ApiClient $api;

    public const CARRIER_USPS_CODE = 21051;
    public const CARRIER_FEDEX_CODE = 100003;
    public const CARRIER_UPS_CODE = 100002;

    public function __construct(string $token)
    {
        $this->api = new ApiClient($token);
    }

    public function register(
        string $trackNumber,
        ?string $tag = null,
        ?string $carrier = self::CARRIER_UPS_CODE
    ): RegisterTrack
    {
        $track = new RegisterTrack($trackNumber, $tag);
        $track->setCarrier($carrier);
        $data = $this->registerMulti([
            $track
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

        $result = $this->api->post('register', $trackNumbers);
        $data = $result['data'];

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

    public function getTrackInfo(string $trackNumber, int $carrier = self::CARRIER_UPS_CODE): TrackInfo
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
     * @return array<TrackInfo>
     */
    public function getTrackInfoMulti(array $trackNumbers): array
    {
        if (count($trackNumbers) > 40) {
            throw new \InvalidArgumentException('单次请求最多40个单号');
        }

        $result = $this->api->post('gettrackinfo', $trackNumbers);

        $data = $result['data'];

        $mapping = [];
        foreach ($trackNumbers as $params) {
            $mapping[$params->getNumber()] = $params;
        }

        $trackList = [];
        foreach ($data['accepted'] ?? [] as $item) {
            $params = $mapping[$item['number']] ?? null;
            if (null === $params) {
                throw new SeventeenRequestException(
                    "Unexpected value {$item['number']} [track info]"
                );
            }

            $track = new TrackInfo($params->getNumber());
            $rawTrack = $item['track'];
            $events = TrackEventAdapter::buildEventsFromArray($rawTrack);
            $track->setSuccess($item['tag'] ?? '', $events, $rawTrack['e'], $rawTrack['is1']);
            $trackList[] = $track;
        }
        foreach ($data['rejected'] ?? [] as $item) {
            $params = $mapping[$item['number']] ?? null;
            if (null === $params) {
                throw new SeventeenRequestException(
                    "Unexpected value {$item['number']} [track info]"
                );
            }

            $track = new TrackInfo($params->getNumber());
            $track->setErrorInfo($item['error']['code'], $item['error']['message']);
            $trackList[] = $track;
        }

        return $trackList;
    }
}
