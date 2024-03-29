<?php

namespace AsyncAws\Illuminate\Queue\Connector;

use AsyncAws\Illuminate\Queue\AsyncAwsSqsQueue;
use AsyncAws\Sqs\SqsClient;
use Illuminate\Contracts\Queue\Queue;
use Illuminate\Queue\Connectors\ConnectorInterface;

class AsyncAwsSqsConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @return Queue
     */
    public function connect(array $config)
    {
        $clientConfig = [];
        if (isset($config['key']) && isset($config['secret'])) {
            $clientConfig['accessKeyId'] = $config['key'];
            $clientConfig['accessKeySecret'] = $config['secret'];
            $clientConfig['sessionToken'] = $config['token'] ?? null;
        }

        if (!empty($config['region'])) {
            $clientConfig['region'] = $config['region'];
        }

        return new AsyncAwsSqsQueue(
            new SqsClient($clientConfig),
            $config['queue'],
            $config['prefix'] ?? '',
            $config['suffix'] ?? ''
        );
    }
}
