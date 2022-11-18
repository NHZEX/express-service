<?php

namespace Zxin\Express\SeventeenTrack\Struct\Track;

class TrackTimeMetrics
{
    /**
     * 订单时效
     * 从第一条事件到 成功签收 事件的间隔天数，累加计数
     */
    public int $days_after_order;
    /**
     * 信息无更新天数
     * 1. 从最后一条事件至今没有更新的间隔天数，累加计数；
     * 2. 当 成功签收 或 退件已签收 时，此数据无意义；
     */
    public int $days_after_last_update;
    /**
     * 运输时效
     * 包裹运输的天数，按以下优先级进行计算：
     * 1. 从 已揽收 状态 到 成功签收 状态；
     * 2. 从 events 集合中查找有 下单 描述的第二条事件到 成功签收 状态；
     * 3. 从第一条事件到 成功签收 状态；
     */
    public int $days_of_transit;
    /**
     * 妥投时效
     * 与 days_of_transit 计算方式一样，在没有 成功签收 状态之前，此项始终为 0，不累加计数。
     */
    public int $days_of_transit_done;
    /**
     * 预期达到时间信息
     * @var array{source: string|null, from: string|null, to: string|null}
     */
    public array $estimated_delivery_date;
}
