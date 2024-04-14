<?php

namespace App\Observers;

use App\Models\Like;
use App\Models\Tweet;
use Aws\AwsClient;
use Aws\DynamoDb\DynamoDbClient;
use Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LikeObserver
{
    /**
     * Handle the Like "created" event.
     */
    public function created(Like $like): void
    {
        $tweet = Tweet::find($like->tweet_id);
        $tweet->increment("likes_count");

        // Crie uma instância do cliente DynamoDB
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
        
        dd($result);

    }

    /**
     * Handle the Like "deleted" event.
     */
    public function deleted(Like $like): void
    {
        $tweet = Tweet::find($like->tweet_id);
        $tweet->decrement("likes_count");
    }

}
