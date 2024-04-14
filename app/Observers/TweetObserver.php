<?php

namespace App\Observers;

use App\Models\Tweet;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;

class TweetObserver
{
    /**
     * Handle the Tweet "created" event.
     */
    public function created(Tweet $tweet): void
    {
        $dynamoDb = new DynamoDbClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $result = $dynamoDb->scan([
            'TableName' => 'mdwitter-logs',
        ]);
        
        $log_id = strval(count($result["Items"]));

        $marshaler = new Marshaler();

        $item = [
            'log_key' => $log_id,
            'log' => 'Tweet ' . $tweet->id . ' Criado',
            'data' => json_encode($tweet)
        ];

        $dadosFormatados = $marshaler->marshalItem($item);

        $dynamoDb->putItem([
            'TableName' => 'mdwitter-logs',
            'Item' => $dadosFormatados,
        ]);
    }

    /**
     * Handle the Tweet "deleted" event.
     */
    public function deleted(Tweet $tweet): void
    {
        $dynamoDb = new DynamoDbClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $result = $dynamoDb->scan([
            'TableName' => 'mdwitter-logs',
        ]);
        
        $log_id = strval(count($result["Items"]));

        $marshaler = new Marshaler();

        $item = [
            'log_key' => $log_id,
            'log' => 'Tweet ' . $tweet->id . ' Deletado',
            'data' => json_encode($tweet)
        ];

        $dadosFormatados = $marshaler->marshalItem($item);

        $dynamoDb->putItem([
            'TableName' => 'mdwitter-logs',
            'Item' => $dadosFormatados,
        ]);
    }
}
