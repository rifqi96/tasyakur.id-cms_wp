<?php
use Tasyakur\App;
use Tasyakur\Core\Container;
use Tasyakur\Core\Contracts\ContainerInterface;
use Tasyakur\Services\MediaService;
use Tasyakur\Services\PostService;
use Tasyakur\Facades\MessageQueue\Queue;
use Tasyakur\Queues\Messages\SendWpMailMessage;

if (!function_exists('isJson')) {
    /**
     * Check if given string is a json
     *
     * @param string
     * @return bool
     */
    function isJson($string): bool
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

if (!function_exists('replaceFileExt')) {
    /**
     * Replace a file extension from a string
     *
     * @param string $fileName
     * @param string|callable $newExt A string to the new file ext or a custom callable response.
     *      If it's a callable, it takes one argument which is the file name without the ext. If callable is applied, this will be the return value.
     * @return string|mixed string by default if $newExt is also a string, but could be different if $newExt is a callable
     */
    function replaceFileExt(string $fileName, $newExt = null)
    {
        // Split string by dot (to take out the extension)
        $newFileNameArr = explode('.', $fileName);

        // Bail early if nothing can be replaced
        if (!is_array($newFileNameArr) || count($newFileNameArr) < 1) return false;

        // Declare new file name
        $newFileName = '';

        // Last index of the array is always the original extension. Unset to take out the extension.
        unset($newFileNameArr[count($newFileNameArr) - 1]);

        foreach ($newFileNameArr as $i => $newFileNameChunk) {
            // First part of the string doesn't need to be re-glued by a dot (.)
            if ($i === 0)
                $newFileName .= $newFileNameChunk;
            else
                $newFileName .= ".$newFileNameChunk";
        }

        if (is_string($newExt)) {
            $newFileName .= ".$newExt";
        } // If $newExt is a callback, replace the function from its response
        else if (is_callable($newExt)) {
            $newFileName = call_user_func($newExt, $newFileName);
        }

        return $newFileName;
    }
}

if (!function_exists('removeFileExt')) {
    /**
     * Remove a file extension from a string
     *
     * @param string $fileName
     * @return string
     */
    function removeFileExt(string $fileName): string
    {
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
    }
}

if (!function_exists('requireAllFiles')) {
    /**
     * Use a string pattern to require() multiple files
     *
     * @param string $dir
     * @return void
     */
    function requireAllFiles(string $dir)
    {
        $files = glob($dir);

        foreach ($files as $file) {
            require($file);
        }
    }
}

if (!function_exists('app')) {
    /**
     * An alias for app container
     *
     * @param string $serviceClass
     * @param array $params Optional - Manually resolve constructor params
     * @return ContainerInterface|App|mixed
     */
    function app(string $serviceClass = null, array $params = [])
    {
        $container = Container::getInstance();

        if (!is_null($serviceClass) && method_exists($container, 'make'))
            return $container->make($serviceClass, $params);

        return $container;
    }
}

if (!function_exists('dd')) {
    /**
     * A function to debug anything
     *
     * @param array ...$debugObj The objects to debug
     * @return bool|mixed
     */
    function dd(...$debugObj)
    {
        if (!is_array($debugObj) && func_num_args() > 0)
            $debugObj = func_get_args();

        if (count($debugObj) === 1)
            $debugObj = $debugObj[0];

        echo "<pre>";
        var_dump($debugObj);
        echo "</pre>";
        exit;
    }
}

if (!function_exists('getUrlQuery')) {
    /**
     * Get queries out of a url
     * @param string $url
     * @return array
     */
    function getUrlQuery(string $url): array
    {
        $parsedUrl = parse_url($url);
        parse_str($parsedUrl['query'], $urlQueries);

        return $urlQueries ?? [];
    }
}

if (!function_exists('leadingSlashIt')) {
    /**
     * Add a slash to the beginning of a string
     * @param string $s
     * @return string
     */
    function leadingSlashIt(string $s): string
    {
        return ($s && $s[0] !== '/') ? '/' . $s : $s;
    }
}

if (!function_exists('cleanDoubleSlash')) {
    /**
     * Clean duplicate slashes
     * @param string $str
     * @return string
     */
    function cleanDoubleSlash(string $str): string
    {
        while (strpos($str, '//') !== false) {
            $str = str_replace('//', '/', $str); //avoid duplicate slashes.
        }

        return $str;
    }
}

if (!function_exists('cleanLastSlash')) {
    /**
     * Remove slash at the last of the string if any
     * @param string $s
     * @return string
     */
    function cleanLastSlash(string $s): string
    {
        return ($s && $s[strlen($s) - 1] === '/') ? substr($s, 0, strlen($s) - 1) : $s;
    }
}

if (!function_exists('doesRequestHttps')) {
    /**
     * Check whether current request is requesting https
     * @return bool
     */
    function doesRequestHttps(): bool
    {
        return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    }
}

if (!function_exists('renderErrorBox')) {
    /**
     * A function to render an error box
     * @param string $str
     */
    function renderErrorBox(string $str)
    {
        ?>
        <div id="message" class="error notice is-dismissible">
            <p><?= $str ?></p>
        </div>
        <?php
    }
}

if (!function_exists('rmdirRecursive')) {
    /**
     * Remove a dir recursively
     * @param string $dir
     * @return bool
     */
    function rmdirRecursive(string $dir): bool
    {
        try {
            foreach (glob("{$dir}/*") as $file) {
                if (is_dir($file)) {
                    rmdirRecursive($file);
                } else {
                    unlink($file);
                }
            }

            return is_dir($dir) ? rmdir($dir) : true;
        } catch (\Throwable $e) {
            renderErrorBox($e->getMessage());
            return false;
        }
    }
}

if (!function_exists('refreshPage')) {
    /**
     * Redirect to the page the user came from.
     * Should be the admin page. If the referred isn't set, then redirects the user to the login page.
     *
     * @return void
     */
    function refreshPage()
    {
        // To make the Coding Standards happy, we have to initialize this.
        if (!isset($_POST['_wp_http_referer'])) { // Input var okay.
            $_POST['_wp_http_referer'] = wp_login_url();
        }

        // Sanitize the value of the $_POST collection for the Coding Standards.
        $url = sanitize_text_field(
            wp_unslash($_POST['_wp_http_referer']) // Input var okay.
        );

        // Finally, redirect back to the admin page.
        wp_safe_redirect(urldecode($url));
        exit;
    }
}

if (!function_exists('addResponseToSession')) {
    /**
     * Flash a message when response is set on session
     * @param int|string|mixed $status
     * @param string $message
     * @param array $data
     * @return void
     */
    function createSessionResponse($status, string $message = '', array $data = [])
    {
        if (!isset($_SESSION['response'])) {
            $_SESSION['response'] = [];
        }
        $_SESSION['response']['status'] = $status;
        $_SESSION['response']['message'] = $message;
        $_SESSION['response']['data'] = $data;
    }
}

if (!function_exists('flashAdminNotice')) {
    /**
     * Flash an admin notice message
     * @param string $message
     * @param int $code
     * @param array $data Optional. Print out if not empty.
     * @param string $noticeType
     * @param bool $isDismissible
     */
    function flashAdminNotice(string $message = '', $code = 500, array $data = [], string $noticeType = 'error', bool $isDismissible = false)
    {
        add_action('admin_notices', function () use ($message, $code, $data, $noticeType, $isDismissible) {
            $class = "notice notice-$noticeType";
            if ($isDismissible)
                $class .= ' is-dismissible';
            $message = _($message, $code);

            echo "<div class='" . esc_attr($class) . "'>";
            echo "<p>" . esc_html($message) . "</p>";
            if (!empty($data)) {
                foreach ($data as $val) {
                    echo "<p><pre>" . print_r($val) . "</pre></p>";
                }
            }
            echo "</div>";
        });
    }
}

/**
 * Overrides default wp_mail function
 * @param string|array $to Array or comma-separated list of email addresses to send message.
 * @param string $subject Email subject
 * @param string $message Message contents
 * @param string|array $headers Optional. Additional headers.
 * @param string|array $attachments Optional. Files to attach.
 * @return bool Whether the email contents were sent successfully.
 */
function wp_mail($to, string $subject, string $message, $headers = '', $attachments = []): bool
{
    try {
        // Send email logic
        $res = \Tasyakur\Facades\Mail\Mail::send($to, $subject, $message, $headers, $attachments);

        if (!$res)
            throw new Exception('Mailer library returned false');

        return true;
    } catch (Exception $e) {
        echo "SendEmailHandler: Error sending email - {$e->getMessage()} - in {$e->getFile()} at line {$e->getLine()} - Trace: \n";
        var_dump($e->getTrace());
        return false;
    } catch (\Whoops\Exception\ErrorException $e) {
        echo "Email might have been sent, but an error occured. {$e->getMessage()} - in {$e->getFile()} at line {$e->getLine()} - Trace: \n";
        var_dump($e->getTrace());
        return false;
    }
}
