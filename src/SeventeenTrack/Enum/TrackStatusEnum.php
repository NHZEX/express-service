<?php

namespace Zxin\Express\SeventeenTrack\Enum;

final class TrackStatusEnum
{
    // 查询不到，进行查询操作但没有得到结果，原因请参看子状态。
    public const NotFound = 'NotFound';
    // 收到信息，运输商收到下单信息，等待上门取件。
    public const InfoReceived = 'InfoReceived';
    // 运输途中，包裹正在运输途中，具体情况请参看子状态。
    public const InTransit = 'InTransit';
    // 运输过久，包裹已经运输了很长时间而仍未投递成功。
    public const Expired = 'Expired';
    // 到达待取，包裹已经到达目的地的投递点，需要收件人自取。
    public const AvailableForPickup = 'AvailableForPickup';
    // 派送途中，包裹正在投递过程中。
    public const OutForDelivery = 'OutForDelivery';
    // 投递失败，包裹尝试派送但未能成功交付，原因请参看子状态。
    // 原因可能是：派送时收件人不在家、投递延误重新安排派送、收件人要求延迟派送、地址不详无法派送、因偏远地区不提供派送服务等。
    public const DeliveryFailure = 'DeliveryFailure';
    // 成功签收，包裹已妥投。
    public const Delivered = 'Delivered';
    // 可能异常，包裹可能被退回，原因请参看子状态。原因可能是：收件人地址错误或不详、收件人拒收、包裹无人认领超过保留期等。包裹可能被海关扣留。
    // 常见扣关原因是：包含敏感违禁、限制进出口的物品、未交税款等。包裹可能在运输途中遭受损坏、丢失、延误投递等特殊情况。
    public const Exception = 'Exception';

    public const STATUS_DESC = [
        self::NotFound           => '查询不到',
        self::InfoReceived       => '收到信息',
        self::InTransit          => '运输途中',
        self::Expired            => '运输过久',
        self::AvailableForPickup => '到达待取',
        self::OutForDelivery     => '派送途中',
        self::DeliveryFailure    => '投递失败',
        self::Delivered          => '成功签收',
        self::Exception          => '可能异常',
    ];

    // ======= 子状态 =======

    public const SUB_NotFound_Other       = 'NotFound_Other';
    public const SUB_NotFound_InvalidCode = 'NotFound_InvalidCode';

    public const SUB_InfoReceived = 'InfoReceived';

    public const SUB_InTransit_PickedUp  = 'InTransit_PickedUp';
    public const SUB_InTransit_Other     = 'InTransit_Other';
    public const SUB_InTransit_Departure = 'InTransit_Departure';
    public const SUB_InTransit_Arrival   = 'InTransit_Arrival';

    public const SUB_Expired_Other = 'Expired_Other';

    public const SUB_AvailableForPickup_Other = 'AvailableForPickup_Other';

    public const SUB_OutForDelivery_Other = 'OutForDelivery_Other';

    public const SUB_DeliveryFailure_Other          = 'DeliveryFailure_Other';
    public const SUB_DeliveryFailure_NoBody         = 'DeliveryFailure_NoBody';
    public const SUB_DeliveryFailure_Security       = 'DeliveryFailure_Security';
    public const SUB_DeliveryFailure_Rejected       = 'DeliveryFailure_Rejected';
    public const SUB_DeliveryFailure_InvalidAddress = 'DeliveryFailure_InvalidAddress';

    public const SUB_Delivered_Other = 'Delivered_Other';

    public const SUB_Exception_Other     = 'Exception_Other';
    public const SUB_Exception_Returning = 'Exception_Returning';
    public const SUB_Exception_Returned  = 'Exception_Returned';
    public const SUB_Exception_NoBody    = 'Exception_NoBody';
    public const SUB_Exception_Security  = 'Exception_Security';
    public const SUB_Exception_Damage    = 'Exception_Damage';
    public const SUB_Exception_Rejected  = 'Exception_Rejected';
    public const SUB_Exception_Delayed   = 'Exception_Delayed';
    public const SUB_Exception_Lost      = 'Exception_Lost';
    public const SUB_Exception_Destroyed = 'Exception_Destroyed';
    public const SUB_Exception_Cancel    = 'Exception_Cancel';

    public const SUB_STATUS_DESC = [
        self::SUB_NotFound_Other                 => '运输商没有返回信息',
        self::SUB_NotFound_InvalidCode           => '物流单号无效，无法进行查询',
        self::SUB_InfoReceived                   => '收到信息',
        self::SUB_InTransit_PickedUp             => '已揽收',
        self::SUB_InTransit_Other                => '其它情况',
        self::SUB_InTransit_Departure            => '已离港',
        self::SUB_InTransit_Arrival              => '已到港',
        self::SUB_Expired_Other                  => '其它原因',
        self::SUB_AvailableForPickup_Other       => '其它原因',
        self::SUB_OutForDelivery_Other           => '其它原因',
        self::SUB_DeliveryFailure_Other          => '其它原因',
        self::SUB_DeliveryFailure_NoBody         => '找不到收件人',
        self::SUB_DeliveryFailure_Security       => '安全原因',
        self::SUB_DeliveryFailure_Rejected       => '拒收包裹',
        self::SUB_DeliveryFailure_InvalidAddress => '收件地址错误',
        self::SUB_Delivered_Other                => '其它原因',
        self::SUB_Exception_Other                => '其它原因',
        self::SUB_Exception_Returning            => '退件处理中',
        self::SUB_Exception_Returned             => '退件已签收',
        self::SUB_Exception_NoBody               => '没人签收',
        self::SUB_Exception_Security             => '安全原因',
        self::SUB_Exception_Damage               => '货品损坏了',
        self::SUB_Exception_Rejected             => '被拒收了',
        self::SUB_Exception_Delayed              => '因各种延迟情况导致的异常',
        self::SUB_Exception_Lost                 => '包裹丢失了',
        self::SUB_Exception_Destroyed            => '包裹被销毁了',
        self::SUB_Exception_Cancel               => '物流订单被取消了',
    ];

    public static function toStatusDesc(string $val, ?string $default = 'unknown'): ?string
    {
        return self::STATUS_DESC[$val] ?? $default;
    }

    public static function toSubStatusDesc(string $val, ?string $default = 'unknown'): ?string
    {
        return self::SUB_STATUS_DESC[$val] ?? $default;
    }
}
