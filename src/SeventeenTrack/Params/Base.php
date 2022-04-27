<?php

namespace Zxin\Express\SeventeenTrack\Params;

use Zxin\Express\SeventeenTrack\ShipmentTracker;
use function get_object_vars;

abstract class Base implements \JsonSerializable
{
    protected string $number;

    protected ?int $carrier;

    protected int $_errorCode = 0;

    protected ?string $_errorMessage = null;

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return int|null
     */
    public function getCarrier(): ?int
    {
        return $this->carrier;
    }

    /**
     * @param int|null $carrier
     */
    public function setCarrier(?int $carrier): void
    {
        $this->carrier = $carrier;
    }

    public function withCarrier(?int $carrier): self
    {
        $this->carrier = $carrier;
        return $this;
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

    public function jsonSerialize(): array
    {
        $result = [];
        foreach (get_object_vars($this) as $key => $val) {
            if (null === $val || '_' === $key[0]) {
                continue;
            }
            $result[$key] = $val;
        }
        return $result;
    }
}
