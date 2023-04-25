<?php defined('BASEPATH') or exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
 * Easy!Appointments - Online Appointment Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) Alex Tselegidis
 * @license     https://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        https://easyappointments.org
 * @since       v1.4.0
 * ---------------------------------------------------------------------------- */

if ( ! function_exists('e'))
{
    /**
     * HTML escape function for templates.
     *
     * Use this helper function to easily escape all the outputted HTML markup.
     *
     * Example:
     *
     * <?= e($string) ?>
     *
     * @param mixed $string Provide anything that can be converted to a string.
     */
    function e(mixed $string): string
    {
        return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
    }
}

if ( ! function_exists('component'))
{
    /**
     * Render a component from the "views/components/*.php" directory.
     *
     * Use this helper function to easily include components into your HTML markup.
     *
     * Any loaded template variables will also be available at the component template, but you may also specify
     * additional values by adding values to the $params parameter.
     *
     * Example:
     *
     * echo component('timezones_dropdown', ['attributes' => 'class"form-control"'], TRUE);
     *
     * @param string $component Component template file name.
     * @param array $vars Additional parameters for the component.
     * @param bool $return Whether to return the HTML or echo it directly.
     *
     * @return string|object Return the HTML if the $return argument is TRUE or NULL.
     */
    function component(string $component, array $vars = [], bool $return = FALSE): string|object
    {
        /** @var EA_Controller $CI */
        $CI = get_instance();

        return $CI->load->view('components/' . $component, $vars, $return);
    }
}

if ( ! function_exists('extend'))
{
    /**
     * Use this function at the top of view files to mark the layout you are extending from.
     *
     * @param $layout
     */
    function extend($layout): void
    {
        config([
            'layout' => [
                'filename' => $layout,
                'sections' => [],
                'tmp' => [],
            ]
        ]);
    }
}

if ( ! function_exists('section'))
{
    /**
     * Use this function in view files to mark the beginning and/or end of a layout section.
     *
     * Sections will only be used if the view file extends a layout and will be ignored otherwise.
     *
     * Example:
     *
     * <?php section('content') ?>
     *
     *   <!-- Section Starts -->
     *
     *   <p>This is the content of the section.</p>
     *
     *   <!-- Section Ends -->
     *
     * <?php section('content') ?>
     *
     * @param string $name
     */
    function section(string $name): void
    {
        $layout = config('layout');

        if (array_key_exists($name, $layout['tmp']))
        {
            $layout['sections'][$name][] = ob_get_clean();

            unset($layout['tmp'][$name]);

            config(['layout' => $layout]);

            return;
        }

        if (empty($layout['sections'][$name]))
        {
            $layout['sections'][$name] = [];
        }

        $layout['tmp'][$name] = '';

        config(['layout' => $layout]);

        ob_start();
    }
}

if ( ! function_exists('end_section'))
{
    /**
     * Use this function in view files to mark the end of a layout section.
     *
     * Sections will only be used if the view file extends a layout and will be ignored otherwise.
     *
     * Example:
     *
     * <?php section('content') ?>
     *
     *   <!-- Section Starts -->
     *
     *   <p>This is the content of the section.</p>
     *
     *   <!-- Section Ends -->
     *
     * <?php end_section('content') ?>
     *
     * @param string $name
     */
    function end_section(string $name): void
    {
        $layout = config('layout');

        if (array_key_exists($name, $layout['tmp']))
        {
            $layout['sections'][$name][] = ob_get_clean();

            unset($layout['tmp'][$name]);

            config(['layout' => $layout]);
        }
    }
}

if ( ! function_exists('slot'))
{
    /**
     * Use this function in view files to mark a slot that sections can populate from within child templates.
     *
     * @param string $name
     */
    function slot(string $name): void
    {
        $layout = config('layout');

        $section = $layout['sections'][$name] ?? NULL;

        if ( ! $section)
        {
            return;
        }

        foreach ($section as $content)
        {
            echo $content;
        }
    }
}

/**
 * Increases or decreases the brightness of a color by a percentage of the current brightness.
 *
 * @param   string  $hexCode        Supported formats: `#FFF`, `#FFFFFF`, `FFF`, `FFFFFF`
 * @param   float   $adjustPercent  A number between -1 and 1. E.g. 0.3 = 30% lighter; -0.4 = 40% darker.
 *
 * @return  string
 *
 * @author  maliayas
 */
function adjustBrightness($hexCode, $adjustPercent) {
    $hexCode = ltrim($hexCode, '#');

    if (strlen($hexCode) == 3) {
        $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
    }

    $hexCode = array_map('hexdec', str_split($hexCode, 2));

    foreach ($hexCode as & $color) {
        $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
        $adjustAmount = ceil($adjustableLimit * $adjustPercent);

        $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
    }

    return '#' . implode($hexCode);
}
