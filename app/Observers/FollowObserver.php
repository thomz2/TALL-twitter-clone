<?php

namespace App\Observers;

use App\Models\Follow;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;

class FollowObserver
{
    /**
     * Handle the Follow "created" event.
     */
    public function created(Follow $follow): void
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
            'log' => 'Follow ' . $follow->id . ' Criado',
            'data' => json_encode($follow)
        ];

        $dadosFormatados = $marshaler->marshalItem($item);

        $dynamoDb->putItem([
            'TableName' => 'mdwitter-logs',
            'Item' => $dadosFormatados,
        ]);
    }

    /**
     * Handle the Follow "deleted" event.
     */
    public function deleted(Follow $follow): void
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
            'log' => 'Follow ' . $follow->id . ' Deletado',
            'data' => json_encode($follow)
        ];

        $dadosFormatados = $marshaler->marshalItem($item);

        $dynamoDb->putItem([
            'TableName' => 'mdwitter-logs',
            'Item' => $dadosFormatados,
        ]);
    }
}
