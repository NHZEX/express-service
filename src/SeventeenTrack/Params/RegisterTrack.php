<?php

namespace Zxin\Express\SeventeenTrack\Params;

class RegisterTrack extends Base
{
    protected bool $auto_detection = false;

    protected ?string $tag = null;

    protected ?bool $_register = false;

    public function __construct(string $number, ?int $carrier = null, ?string $tag = null)
    {
        $this->number = $number;
        $this->tag = $tag;
        $this->carrier = $carrier;
    }

    /**
     * @return bool
     */
    public function isAutoDetection(): bool
    {
        return $this->auto_detection;
    }

    /**
     * @param bool $auto_detection
     */
    public function setAutoDetection(bool $auto_detection): void
    {
        $this->auto_detection = $auto_detection;
    }

    /**
     * @return string|null
     */
    public function getTag(): ?string
    {
        return $this->tag;
    }

    /**
     * @return bool|null
     */
    public function isRegister(): ?bool
    {
        return $this->_register;
    }

    /**
     * @param bool|null $register
     */
    public function setRegister(?bool $register): void
    {
        $this->_register = $register;
    }
}
