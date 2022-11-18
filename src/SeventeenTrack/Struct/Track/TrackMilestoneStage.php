<?php

namespace Zxin\Express\SeventeenTrack\Struct\Track;

use function strtolower;

class TrackMilestoneStage
{
    public string  $key_stage;
    public ?string $time_iso;
    public ?string $time_utc;

    private ?\DateTimeImmutable $datetime;

    public function __construct(
        string  $key_stage,
        ?string $time_iso,
        ?string $time_utc
    ) {
        $this->time_utc  = $time_utc;
        $this->time_iso  = $time_iso;
        $this->key_stage = $key_stage;
    }

    public function getLowKeyStage(): string
    {
        return strtolower($this->key_stage);
    }

    public function getDateTime(): ?\DateTimeImmutable
    {
        if (null === $this->time_iso) {
            return null;
        }
        return $this->datetime ??= \DateTimeImmutable::createFromFormat(DATE_ATOM, $this->time_iso);
    }

    public function isAchieve(): bool
    {
        return null !== $this->time_iso;
    }
}
