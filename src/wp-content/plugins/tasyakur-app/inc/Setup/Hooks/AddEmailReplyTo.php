<?php
namespace Tasyakur\Setup\Hooks;

class AddEmailReplyTo implements \Tasyakur\Core\Contracts\HooksInterface
{
    /**
     * @inheritDoc
     */
    public function init()
    {
        add_filter('wp_mail', [$this, 'addReplyTo']);
    }

    /**
     * @param array $attr (
     *  @type string $to
     *  @type string $subject
     *  @type string $message
     *  @type array $headers
     *  @type array $attachments
     * )
     * @return array
     */
    public function addReplyTo(array $attr): array
    {
        $name = get_bloginfo('name');
        $adminEmail = get_bloginfo('admin_email');

        if ($name && $adminEmail)
            $attr['headers'] = ["Reply-To: " . $name . "<". $adminEmail .">"];

        return $attr;
    }
}