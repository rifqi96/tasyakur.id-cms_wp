<?php
if ( ! defined( 'ABSPATH' ) ) {
    /** Set up WordPress environment */
    $wpDir = getenv('WORKDIR') ?? '/var/www/html';
    $wpLoadDir = "$wpDir/wp-load.php";
    if ( ! file_exists( $wpLoadDir ) ) {
        error_log(
            'Tasyakur Queue Fatal Error - Cannot find wp-load.php'
        );
    }
    require_once $wpLoadDir;
}
// Load main app
require_once __DIR__ . '/../../../tasyakur-app.php';

use Tasyakur\Adapters\MessageQueue\Contracts\Handler;
use Tasyakur\Facades\MessageQueue\Queue;
use Tasyakur\Core\Exceptions\SafeException;
use Tasyakur\Facades\MessageQueue\Job;

/**
 * Entry point to run queues
 * To run this: php QueueHandler.php QUEUE_CLASS_NAME
 */
class QueuesHandler
{
    /**
     * Handle the queues
     * @return void
     * @throws \Tasyakur\Core\Exceptions\SafeException
     */
    public function handle(): void
    {
        // Set timeout for restarting the script (current time + 1 min)
        $timeoutAt = time() + 60;

        $dateTimeFormat = 'Y-m-d H:i:s';

        // Continuously loop to endlessly monitor beanstalk queue
        while (true) {
            // To avoid memory leaks, exit if the timing has reached timeout
            // Then supposedly supervisor auto-restarts the script
            if (time() >= $timeoutAt)
                die;

            // List down the queues
            $queueIds = Queue::listQueues();

            // Call a queue facade, watch and return a job
            $watchedJob = Queue::watch($queueIds);

            try {
                // If queue::watch() returns null
                if (!$watchedJob)
                    throw new SafeException();

                /** @var $job Job */
                $job = app()->make(Job::class, [
                    'job' => $watchedJob
                ]);
                // if none wait for a job to be available
                if (!$job->jobExists())
                    throw new SafeException();

                // Get job data
                $data = $job->getData(false);

                if (!isset($data['handlerClass']) || !isset($data['data']))
                    throw new SafeException("Queue data is not in a correct format", 2);

                $handler = app()->make($data['handlerClass'], [
                    'job' => $job
                ]);
                // Skip handling if the instance is not a handler
                if (! $handler instanceof Handler)
                    throw new SafeException("Queue Handler: $data[handlerClass] is not a valid Handler instance. Skipping the handler.", 2);

                $date = date($dateTimeFormat, time());
                echo "[$date] Job #{$handler->getJob()->getJobId()}:";
                echo "\n";
                $handler->handle();

            }
            // Catch:
            // - If no job available, delay for 5 seconds, and continue the loop to skip the rest of the code
            // - Queue data is not in a correct format
            // - Handler instance is not valid
            catch (SafeException $safeException) {
                if ($safeException->getMessage()) {
                    $date = date($dateTimeFormat, time());
                    echo "$date: \n";
                    echo $safeException->getMessage();
                    echo "\n";
                }

                // Delete the job if status code is 2
                if ($safeException->getCode() === 2)
                    $job->delete();

                sleep(5);
            }
        }
    }
}

// Run the handler
$queuesHandler = app()->get(QueuesHandler::class);
$queuesHandler->handle();