<?php

namespace Zxin\Express\SeventeenTrack\Params;

use Carbon\Carbon;

/**
 * @deprecated 待重构
 */
class TrackEvent
{
    /**
     * @var string
     */
    protected string $location;

    /**
     * @var Carbon
     */
    protected Carbon $date;

    /**
     * @var string
     */
    protected string $description;

    /**
     * @var string
     */
    protected string $status;

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation($location): TrackEvent
    {
        $this->location = $location;

        return $this;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }


    /**
     * @param string|Carbon $date
     */
    public function setDate($date): TrackEvent
    {
        $date = $date instanceof Carbon ? $date : Carbon::parse($date);

        $this->date = $date;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): TrackEvent
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus($status): TrackEvent
    {
        $this->status = $status;

        return $this;
    }
}
