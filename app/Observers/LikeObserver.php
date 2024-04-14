<?php

namespace App\Observers;

use App\Models\Like;
use App\Models\Tweet;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;
use Carbon\Carbon;

class LikeObserver
{
    /**
     * Handle the Like "created" event.
     */
    public function created(Like $like): void
    {
        $tweet = Tweet::find($like->tweet_id);
        $tweet->increment("likes_count");

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
            'log' => 'Like ' . $like->id . ' Criado',
            'data' => json_encode($like),
            'time' => Carbon::now()->format('Y-m-d H:i:s')
        ];

        $dadosFormatados = $marshaler->marshalItem($item);

        $dynamoDb->putItem([
            'TableName' => 'mdwitter-logs',
            'Item' => $dadosFormatados,
        ]);
        
    }

    /**
     * Handle the Like "deleted" event.
     */
    public function deleted(Like $like): void
    {
        $tweet = Tweet::find($like->tweet_id);
        $tweet->decrement("likes_count");

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
            'log' => 'Like ' . $like->id . ' Deletado',
            'data' => json_encode($like),
            'time' => Carbon::now()->format('Y-m-d H:i:s')
        ];

        $dadosFormatados = $marshaler->marshalItem($item);

        $dynamoDb->putItem([
            'TableName' => 'mdwitter-logs',
            'Item' => $dadosFormatados,
        ]);
    }

}
