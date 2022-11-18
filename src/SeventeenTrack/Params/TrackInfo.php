<?php

namespace Zxin\Express\SeventeenTrack\Params;

/**
 * @deprecated 待重构
 */
class TrackInfo
{
    const STATUS_CREATE     = 'create';
    const STATUS_IN_TRANSIT = 'in_transit';
    const STATUS_DELIVERED  = 'delivered';
    const STATUS_PICKUP     = 'pickup';
    const STATUS_EXCEPTION  = 'exception';
    const STATUS_WARNING    = 'warning';
    const STATUS_UNKNOWN    = 'unknown';

    protected string $number;

    protected ?string $tag = null;

    protected ?int $packageStatus = null;

    protected ?int $queryStatus = null;
    /**
     * @var TrackEvent[]
     */
    protected array $events = [];

    protected int $_errorCode = 0;

    protected ?string $_errorMessage = null;

    public function __construct(string $number)
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @param string            $tag
     * @param array<TrackEvent> $events
     * @param int               $packageStatus
     * @param int               $queryStatus
     * @return void
     */
    public function setSuccess(
        string $tag,
        array  $events,
        int    $packageStatus,
        int    $queryStatus
    ): void {
        $this->tag    = $tag;
        $this->events = $events;
        $this->packageStatus = $packageStatus;
        $this->queryStatus = $queryStatus;
    }

    /**
     * @return string|null
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @return int|null
     */
    public function getPackageStatus(): ?int
    {
        return $this->packageStatus;
    }

    /**
     * @return int|null
     */
    public function getQueryStatus(): ?int
    {
        return $this->queryStatus;
    }

    /**
     * @return TrackEvent[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    public function setErrorInfo(int $code, string $message)
    {
        $this->_errorCode    = $code;
        $this->_errorMessage = $message;
    }

    public function isError(): bool
    {
        return 0 !== $this->_errorCode;
    }

    /**
     * @return int
     */
    public function getErrorCode(): int
    {
        return $this->_errorCode;
    }

    /**
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->_errorMessage;
    }
}
