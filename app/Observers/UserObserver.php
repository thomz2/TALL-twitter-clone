<?php

namespace App\Observers;

use App\Models\User;
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Marshaler;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
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
            'log' => 'User ' . $user->id . ' Criado',
            'data' => json_encode($user)
        ];

        $dadosFormatados = $marshaler->marshalItem($item);

        $dynamoDb->putItem([
            'TableName' => 'mdwitter-logs',
            'Item' => $dadosFormatados,
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
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
            'log' => 'User ' . $user->id . ' Atualizado',
            'data' => json_encode($user)
        ];

        $dadosFormatados = $marshaler->marshalItem($item);

        $dynamoDb->putItem([
            'TableName' => 'mdwitter-logs',
            'Item' => $dadosFormatados,
        ]);
    }
}
