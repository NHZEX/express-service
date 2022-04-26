<?php

namespace Zxin\Express\SeventeenTrack\Params;

class QueryTrackInfo extends Base
{
    public function __construct(string $number)
    {
        $this->number = $number;
    }
}
