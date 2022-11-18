<?php

namespace Zxin\Express\SeventeenTrack\Struct\Track;

use CuyZ\Valinor\Mapper\Source\Source;

class TrackInfoStruct
{
    // 地区相关信息节点
    /**
     * @var array
     */
    public array $shipping_info;
    /**
     * 最新状态
     * @var array{status: string, sub_status: string, sub_status_descr: string|null}
     */
    public array $latest_status;
    // 最新事件
    public TrackEvent $latest_event;
    // 时效相关信息
    public TrackTimeMetrics $time_metrics;
    // 程碑阶段
    public TrackMilestone $milestone;
    // 包裹附属信息
    public array $misc_info;
    /**
     * @var array{providers_hash: int, providers: array<TrackProvider>}
     */
    public array $tracking;

    public function getHiddenKey(): array
    {
        return [];
    }

    public static function fromArr(array $source): TrackInfoStruct
    {
        return (new \CuyZ\Valinor\MapperBuilder())
            ->allowPermissiveTypes()
            ->allowSuperfluousKeys()
            ->supportDateFormats(DATE_ATOM)
            ->registerConstructor(
                TrackMilestone::class,
            )
            ->mapper()
            ->map(TrackInfoStruct::class, Source::array($source));
    }

    public function getLatestStatus(): array
    {
        return [
            'status'    => $this->latest_status['status'],
            'subStatus' => $this->latest_status['sub_status'],
        ];
    }

}
