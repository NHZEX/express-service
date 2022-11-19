<?php

namespace Zxin\Express\SeventeenTrack\Struct\Track;

use CuyZ\Valinor\Mapper\Source\Source;
use Psr\SimpleCache\CacheInterface;

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
    public ?TrackEvent $latest_event;
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

    public static function fromArr(array $source, ?CacheInterface $cache = null): TrackInfoStruct
    {
        $mapper = (new \CuyZ\Valinor\MapperBuilder());
        if (null !== $cache) {
            $mapper = $mapper->withCache($cache);
        }
        return $mapper->allowPermissiveTypes()
            ->allowSuperfluousKeys()
            ->supportDateFormats(DATE_ATOM)
            ->registerConstructor(
                TrackMilestone::class,
            )
            ->mapper()
            ->map(TrackInfoStruct::class, Source::array($source));
    }
}
