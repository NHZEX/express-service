<?php

namespace Zxin\Express\SeventeenTrack\Struct\Track;

use function dump;
use function func_get_args;
use function strtolower;

class TrackMilestone
{
    /**
     * @var array<int, TrackMilestoneStage>
     */
    private array $items = [];

    /**
     * @var array<string, TrackMilestoneStage>
     */
    private array $stage = [];

    // 默认里程碑
    public const STAGE_InfoReceived       = 'InfoReceived';
    public const STAGE_PickedUp           = 'PickedUp';
    public const STAGE_Departure          = 'Departure';
    public const STAGE_Arrival            = 'Arrival';
    public const STAGE_AvailableForPickup = 'AvailableForPickup';
    public const STAGE_OutForDelivery     = 'OutForDelivery';
    public const STAGE_Delivered          = 'Delivered';
    public const STAGE_Returning          = 'Returning';
    public const STAGE_Returned           = 'Returned';

    public const STAGE_KEYS = [
        self::STAGE_InfoReceived,
        self::STAGE_PickedUp,
        self::STAGE_Departure,
        self::STAGE_Arrival,
        self::STAGE_AvailableForPickup,
        self::STAGE_OutForDelivery,
        self::STAGE_Delivered,
        self::STAGE_Returning,
        self::STAGE_Returned,
    ];

    public function __construct(array $items)
    {
        foreach ($items as $item) {
            $this->items[] = new TrackMilestoneStage(
                $item['key_stage'],
                $item['time_iso'],
                $item['time_utc'],
            );
        }

        $this->parse();
    }

    public static function fromArr(?array $value): TrackMilestone
    {
        return new TrackMilestone($value ?? []);
    }

    private function parse()
    {
        foreach ($this->items as $item) {
            $this->stage[$item->getLowKeyStage()] = $item;
        }
    }

    /**
     * @return array<TrackMilestoneStage>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function hasStage(string $name): bool
    {
        $name = strtolower($name);
        return isset($this->stage[$name]);
    }

    public function getStage(string $name): ?TrackMilestoneStage
    {
        $name = strtolower($name);
        return $this->stage[$name] ?? null;
    }

    public function achieveStage(string $name): bool
    {
        $name = strtolower($name);
        return isset($this->stage[$name]) && $this->stage[$name]->isAchieve();
    }
}
