<?php

namespace Zxin\Express\SeventeenTrack\Struct\Track;

use DateTimeImmutable;

class TrackEvent
{
    // 事件发生时间
    public DateTimeImmutable $time_iso;
    // 	事件发生时间
    public DateTimeImmutable $time_utc;
    // 描述
    public string $description;
    // 地点
    public ?string $location;
    // 阶段内容
    public ?string $stage;
    // 地点信息
    public array $address;
}
