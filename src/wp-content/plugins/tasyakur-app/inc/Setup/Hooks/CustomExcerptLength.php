<?php
namespace Tasyakur\Setup\Hooks;

class CustomExcerptLength implements \Tasyakur\Core\Contracts\HooksInterface
{
    /**
     * @var int
     */
    private $excerptLength;

    /**
     * CustomExcerptLength constructor.
     */
    public function __construct()
    {
        $this->excerptLength = 20;
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        add_filter( 'excerpt_length', [$this, 'getExcerptLength'], 999 );
    }

    /**
     * @return int
     */
    public function getExcerptLength(): int
    {
        return $this->excerptLength;
    }

    /**
     * @param int $excerptLength
     */
    public function setExcerptLength(int $excerptLength): void
    {
        $this->excerptLength = $excerptLength;
    }
}