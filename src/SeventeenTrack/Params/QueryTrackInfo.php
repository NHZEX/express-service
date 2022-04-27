<?php

namespace Zxin\Express\SeventeenTrack\Params;

class QueryTrackInfo extends Base
{
    public function __construct(string $number, ?int $carrier = null)
    {
        $this->number = $number;
        $this->carrier = $carrier;
    }
}
