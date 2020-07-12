<?php
// use Psr\Container\ContainerInterface;
// use function DI\create;
// use function DI\get;
use function DI\autowire;

return [
    // Exception handler: WhoopsHandler
    'Tasyakur\Core\Contracts\HandlerInterface' => autowire('Tasyakur\Core\Exceptions\WhoopsHandler'),

    // Object Storage module: AWS S3
    'Tasyakur\Adapters\ObjectStorage\Contracts\ObjectStorage' => autowire('Tasyakur\Libraries\S3Client\S3Client'),

    // Analytics module: Google analytics
    'Tasyakur\Libraries\GoogleAnalytics\Contracts\GAConfigInterface' => autowire('Tasyakur\Libraries\GoogleAnalytics\GAConfigJsonFile')->constructor(GA_CREDENTIALS_PATH),
    'Tasyakur\Adapters\Analytics\Contracts\Analytics' => autowire('Tasyakur\Libraries\GoogleAnalytics\GoogleAnalytics'),

    // InMemory module: PhpRedis
    'Tasyakur\Adapters\InMemory\Contracts\InMemory' => autowire('Tasyakur\Libraries\PhpRedis\PhpRedis'),

    // MessageQueue module: Pheanstalk
    'Tasyakur\Adapters\MessageQueue\Contracts\QueueDriver' => autowire('Tasyakur\Libraries\Pheanstalk\Pheanstalk')->constructor(\Tasyakur\Adapters\MessageQueue\Contracts\QueueDriver::PHP_SERIALIZER),

    // Mail module: PHPMailer
    'Tasyakur\Adapters\Mail\Contracts\AbstractMail' => autowire('Tasyakur\Libraries\PHPMailer\PHPMailer'),
];