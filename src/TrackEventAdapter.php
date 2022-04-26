<?php

namespace Zxin\Express;

use Zxin\Express\SeventeenTrack\Params\TrackEvent;
use Zxin\Express\SeventeenTrack\Params\TrackInfo;
use Zxin\Express\SeventeenTrack\SeventeenConstant;
use function array_map;
use function array_merge;
use function array_reverse;
use function preg_replace;
use function stripos;
use function strtotime;
use function strtoupper;
use function time;
use function usort;

class TrackEventAdapter
{
    public static function buildEventsFromArray(array $rawTrack): array
    {
        // todo 先构建再合并
        $rawEventsAll = self::mergeCarriersEvents($rawTrack);
        return self::makeTrackEvents($rawEventsAll);
    }

    protected static function mergeCarriersEvents(array $trackInfo): array
    {
        foreach ($trackInfo['z1'] as &$item) {
            $item['carrier'] = 1;
        }
        foreach ($trackInfo['z2'] as &$item) {
            $item['carrier'] = 2;
        }
        if (empty($trackInfo['z2'])) {
            return $trackInfo['z1'];
        }
        $mergedEvents = array_merge($trackInfo['z1'], $trackInfo['z2']);

        usort($mergedEvents, function ($item1, $item2) {
            return strtotime($item2['a']) - strtotime($item1['a']);
        });

        return $mergedEvents;
    }

    protected static function makeTrackEvents(array $track): array
    {
        $events = [];
        foreach ($track as $item) {
            $event = new TrackEvent();
            $event->setDate($item['a']);
            $event->setLocation($item['c']);
            $event->setDescription($item['z']);
            $event->setStatus(self::resolveState($item['z']));
            $events[] = $event;
        }
        return $events;
    }

    protected static function resolveState(string $statusDescription)
    {
        foreach (SeventeenConstant::UPS_EVENT_STATUS as $status => $needles) {
            foreach ($needles as $needle) {
                if (stripos($statusDescription, $needle) !== false) {
                    return $status;
                }
            }
        }

        return TrackInfo::STATUS_UNKNOWN;
    }
}
