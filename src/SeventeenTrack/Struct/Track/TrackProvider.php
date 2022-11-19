<?php

namespace Zxin\Express\SeventeenTrack\Struct\Track;

use DateTimeImmutable;

class TrackProvider
{
    // 运输商信息
    public array $provider;
    // 	服务类型
    public ?string $service_type;
    // 最近同步状态
    public string $latest_sync_status;
    // 最近同步时间
    public DateTimeImmutable $latest_sync_time;
    // 事件哈希值
    public int $events_hash;
    /**
     * 事件集合
     * @var array<TrackEvent>
     */
    public array $events;
}
