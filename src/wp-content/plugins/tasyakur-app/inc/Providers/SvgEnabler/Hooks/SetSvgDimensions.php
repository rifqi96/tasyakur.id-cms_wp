<?php
namespace Tasyakur\Providers\SvgEnabler\Hooks;

use Tasyakur\Core\Contracts\HooksInterface;

class SetSvgDimensions implements HooksInterface
{

    /**
     * Register the hook function
     *
     * @return void
     */
    public function init()
    {
        add_filter('wp_prepare_attachment_for_js', [$this, 'setDimensions'], 10, 3);
    }

    /**
     * This is a decent way of grabbing the dimensions of SVG files.
     * I believe this to be a reasonable dependency and should be common enough to
     * not cause problems.
     * @param $svg
     * @return object
     */
    public function getDimensions($svg)
    {
        // Sometimes, for whatever reason, we still cannot get the attributes.
        // If that happens, we will just go back to not knowing the dimensions,
        // rather than breaking the site.
        $fail = (object)array('width' => 0, 'height' => 0);

        // Welp, nothing we can do here...
        if (!function_exists('simplexml_load_file')) {
            return $fail;
        }

        $svg = simplexml_load_file($svg);
        $attributes = $svg ? $svg->attributes() : false;

        // Probably an invalid XML file?
        if (!$attributes) {
            return $fail;
        }

        $width = (string)$attributes->width;
        $height = (string)$attributes->height;

        return (object)array('width' => $width, 'height' => $height);
    }

    /**
     * Browsers may or may not show SVG files properly without a height/width.
     * WordPress specifically defines width/height as "0" if it cannot figure it out.
     * Thus the below is needed.
     * Consider this the "server side" fix for dimensions.
     * Which is needed for the Media Grid within the Administration area.
     *
     * @param $response
     * @param $attachment
     * @param $meta
     * @return mixed
     */
    public function setDimensions($response, $attachment, $meta)
    {
        if ($response['mime'] == 'image/svg+xml' && empty($response['sizes'])) {
            $svgFilePath = get_attached_file($attachment->ID);
            $dimensions = $this->getDimensions($svgFilePath);

            $response['sizes'] = array(
                'full' => array(
                    'url' => $response['url'],
                    'width' => $dimensions->width,
                    'height' => $dimensions->height,
                    'orientation' => $dimensions->width > $dimensions->height ? 'landscape' : 'portrait'
                )
            );
        }

        return $response;
    }
}