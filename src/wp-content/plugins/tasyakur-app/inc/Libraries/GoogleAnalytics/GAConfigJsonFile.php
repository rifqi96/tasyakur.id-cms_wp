<?php

namespace Tasyakur\Libraries\GoogleAnalytics;

use Tasyakur\Libraries\GoogleAnalytics\Contracts\GAConfigInterface;

/**
 * Converts json file to an array of ga config
 */
class GAConfigJsonFile implements GAConfigInterface
{
    private $GAConfig = [];

    /**
     * GAConfigJsonFile constructor.
     * @param string $KEY_FILE_LOCATION Path to the json key file
     */
    public function __construct(string $KEY_FILE_LOCATION)
    {
        $GAConfig = [];
        if (is_string($KEY_FILE_LOCATION)) {
            if (!file_exists($KEY_FILE_LOCATION)) {
                throw new \InvalidArgumentException('file does not exist');
            }

            $json = file_get_contents($KEY_FILE_LOCATION);

            if (!$GAConfig = json_decode($json, true)) {
                throw new \LogicException('invalid json for auth config');
            }
        }
        $this->GAConfig = $GAConfig;
    }

    /**
     * {@inheritdoc}
     * @see GAConfigInterface::get()
     */
    public function get(): array
    {
        return $this->GAConfig;
    }
}