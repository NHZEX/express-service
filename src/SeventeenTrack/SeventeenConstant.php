<?php

namespace Zxin\Express\SeventeenTrack;

use Zxin\Express\SeventeenTrack\Params\TrackInfo;

class SeventeenConstant
{
    // 包裹状态
    public const PS_NOT_FOUND   = 0;  // 查询不到
    public const PS_IN_TRANSIT  = 10; // 运输途中
    public const PS_EXPIRED     = 20; // 运输过久
    public const PS_PICK_UP     = 30; // 到达待取
    public const PS_UNDELIVERED = 35; // 投递失败
    public const PS_DELIVERED   = 40; // 成功签收
    public const PS_ALERT       = 50; // 可能异常

    const PS_DESC = [
        self::PS_NOT_FOUND   => 'Not found',
        self::PS_IN_TRANSIT  => 'In transit',
        self::PS_EXPIRED     => 'Expired',
        self::PS_PICK_UP     => 'Pick up',
        self::PS_UNDELIVERED => 'Undelivered',
        self::PS_DELIVERED   => 'Delivered',
        self::PS_ALERT       => 'Alert',
    ];

    // 追踪状态
    public const TS_UNABLE_TO_TRACK     = 0;  // 无法识别
    public const TS_NORMAL_TRACKING     = 1;  // 正常查有信息
    public const TS_NOT_FOUND           = 2;  // 尚无信息
    public const TS_WEB_ERROR           = 10; // 网站错误
    public const TS_PROCESS_ERROR       = 11; // 处理错误
    public const TS_SERVICE_ERROR       = 12; // 查询错误
    public const TS_WEB_ERROR_CACHE     = 20; // 网站错误，使用缓存
    public const TS_PROCESS_ERROR_CACHE = 21; // 处理错误，使用缓存
    public const TS_SERVICE_ERROR_CACHE = 22; // 查询错误，使用缓存


    public const UPS_EVENT_STATUS = [
        TrackInfo::STATUS_CREATE                => [
            'Shipper created a label',
            'Shipping Label Created',
            'not received the package yet',
            'created a label',
        ],
        TrackInfo::STATUS_PICKUP     => [
            'UPS Access Point™ possession',
            'Delivered to UPS Access Point™',
            'this package to be held for pickup at the UPS facility',
            'currently at the UPS Access Point™',
            'pickup the package at a UPS location',
            'package is being held for pickup',
            'Pickup must',
        ],
        TrackInfo::STATUS_IN_TRANSIT => [
            'Ready for UPS',
            'Scan',
            'Out For Delivery',
            'receiver requested a hold for a future delivery date',
            'receiver was not available at the time of the first delivery attempt',
            'The address has been corrected',
            'A final attempt will be made',
            'Will deliver to a nearby UPS Access Point™ for customer pick up',
            'Customer was not available when UPS attempted delivery',
            'Arrived at Facility',
            'Departed from Facility',
            'Order Processed',
            'The package will be delivered to the recipient’s preferred UPS Access Point™ location',
            'Your package is in transit',
            'Processing at UPS Facility',
            'updated the delivery information for your package',
            'The package has been rerouted to the correct destination',
            'Loaded on Delivery Vehicle',
            'Package is in transit to a UPS facility',
            'your package is on its way',
            'Delivery has been rescheduled',
            'Drop-Off',
            'Package transferred to post office',
            'Your delivery has been rescheduled',
            'delivery change was completed',
            'package is on it\'s way to the updated address',
            'package for clearance',
            'change to the delivery address',
            'address was corrected',
            'receiver has moved',
            'package is being held for a future delivery date',
        ],
        TrackInfo::STATUS_WARNING    => [
            'attempting to obtain a new delivery address',
            'A delivery change for this package is in progress',
            'The receiver was not available at the time of the final delivery attempt',
            'Uncontrollable events have delayed delivery',
            'The sender requested that we hold this package',
            'We received a request from the receiver to reschedule the delivery',
            'your package may be delayed',
            'Severe weather conditions have delayed delivery',
            'has delayed delivery',
            'We were unable to dispatch the trailer on time',
            'This may cause a delay',
            'delivery change option was modified',
            'adjusting plans to deliver your package as quickly as possible',
            'Your delivery will be rescheduled',
            'duplicate tracking numbers',
            'A late UPS trailer arrival has caused a delay',
            'has caused a delay',
            'We tried to deliver to the business',
            'but it was closed',
            'rescheduled for a future delivery date',
            'The package remains at the UPS Access Point™ location',
            'is reaching the maximum days allowed to be held',
            'Sensor Event Received',
            'holiday closures',
            'your package was delayed',
            'delivery plans as quickly as possible',
            'The receiving business was closed',
            'tried to pickup the package',
            'not ready for pickup',
            'Delivery will be delayed by',
            'investigation to locate the package',
            'may delay delivery',
            'receiver was not available',
            'The suite number is either missing or incorrect',
            'Weather conditions',
            'have delayed',
            'been damaged',
            'was damaged',
            'verify the package location',
            'sender requested that we return this package',
            'package exceeds the maximum length we can accept',
            'package was given to UPS after the cutoff time',
        ],
        TrackInfo::STATUS_EXCEPTION  => [
            'Exception',
            'The address is incomplete',
            'is incorrect',
            'receiver was not available at the time of the final delivery attempt',
            'Merchandise is missing',
            'All merchandise missing',
            'Returned to shipper',
            'The package cannot be taken to the intended UPS Location',
            'Please select Change My Delivery to make alternate arrangements',
            'Package could not be located for intercept',
            'An investigation has been opened for your lost package',
            'A claim has been issued to the sender for your package',
            'The package was refused',
            'All merchandise was not recoverable',
            'was discarded',
            'The investigation requires additional merchandise description',
            'Service disruption occurred',
            'returned to the sende',
            'package is not claim eligible because',
            'Voided Information',
            'Significant weather events',
            'severe weather',
            'incorrectly sorted this package',
            'refused the delivery',
            'receiver does not want the product',
        ],
        TrackInfo::STATUS_DELIVERED  => [
            'Delivered',
            'a proof of delivery',
        ],
    ];
}
