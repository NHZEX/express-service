<?php

namespace Zxin\Express\SeventeenTrack;

use Zxin\Express\TrackEventAdapter;
use Zxin\Express\SeventeenTrack\Params\TrackInfo;
use function hash;
use function json_encode;

/**
 * @deprecated 待重构
 */
class SeventeenTrackEvent
{
    public const EVENT_TRACKING_STOPPED = 'TRACKING_STOPPED';
    public const EVENT_TRACKING_UPDATED = 'TRACKING_UPDATED';

    private string $token;

    private ?string $errMessage = null;
    private ?string $warnMessage = null;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string|null
     */
    public function getErrMessage(): ?string
    {
        return $this->errMessage;
    }

    /**
     * @return string|null
     */
    public function getWarnMessage(): ?string
    {
        return $this->warnMessage;
    }

    public function checkSign(string $event, array $data, string $inputSign): bool
    {
        $text = "{$event}/" . json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "/{$this->token}";

        return $inputSign === hash('sha256', $text);
    }

    /**
     * @param string $event
     * @param array  $data
     * @return array|TrackInfo|null
     */
    public function dispatch(string $event, array $data)
    {
        switch ($event) {
            case self::EVENT_TRACKING_UPDATED:
                return $this->trackingUpdate($data);
            case self::EVENT_TRACKING_STOPPED:
                return $this->trackingStop($data);
        }

        $this->errMessage = "unknown event: {$event}";
        return null;
    }

    public function trackingUpdate(array $data): ?TrackInfo
    {
        if (empty($data['number']) || empty($data['track'])) {
            $this->errMessage = "missing required parameter: number, track";
            return null;
        }

        $number = $data['number'];

        $trackEvents = TrackEventAdapter::buildEventsFromArray($data['track']);
        $trackInfo = new TrackInfo($number);
        $trackInfo->setSuccess('', $trackEvents, 0, 0);

        return $trackInfo;
    }

    public function trackingStop(array $data): ?array
    {
        if (empty($data['carrier']) || empty($data['number']) || !isset($data['tag'])) {
            $this->errMessage = "missing required parameter: carrier, number, tag";
            return null;
        }
        // 默认 ups，不判断 carrier
        // $tag = $data['tag']; 暂时不做判断

        return $data;
    }
}
