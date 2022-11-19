<?php

namespace Zxin\Express\SeventeenTrack\Params;

use Psr\SimpleCache\CacheInterface;
use Zxin\Express\SeventeenTrack\Struct\Track\TrackInfoStruct;

class QueryTrackInfo extends Base
{
    protected ?string $_tag = null;

    // 物流单号附加查询参数
    protected ?string $_param = null;

    protected ?array $_track_info = null;

    private ?TrackInfoStruct $_track_obj = null;

    private ?CacheInterface $_cache = null;

    public function __construct(string $number, ?int $carrier = null)
    {
        $this->number  = $number;
        $this->carrier = $carrier;
    }

    /**
     * @param CacheInterface|null $cache
     */
    public function setCache(?CacheInterface $cache): void
    {
        $this->_cache = $cache;
    }

    /**
     * @return string|null
     */
    public function getTag(): ?string
    {
        return $this->_tag;
    }

    /**
     * @param string|null $tag
     */
    public function setTag(?string $tag): void
    {
        $this->_tag = $tag;
    }

    /**
     * @return string|null
     */
    public function getParam(): ?string
    {
        return $this->_param;
    }

    /**
     * @param string|null $param
     */
    public function setParam(?string $param): void
    {
        $this->_param = $param;
    }

    /**
     * @return array|null
     */
    public function getTrackInfo(): ?array
    {
        return $this->_track_info;
    }

    /**
     * @return TrackInfoStruct|null
     */
    public function getTrackObj(): ?TrackInfoStruct
    {
        return null === $this->_track_info
            ? null
            : ($this->_track_obj ??= TrackInfoStruct::fromArr($this->_track_info, $this->_cache));
    }

    /**
     * @param array|null $track_info
     */
    public function setTrackInfo(?array $track_info): void
    {
        $this->_track_info = $track_info;
    }
}
