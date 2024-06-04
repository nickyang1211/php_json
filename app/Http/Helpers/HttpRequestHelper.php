<?php  

namespace App\Http\Helpers;  
use Exception;

use GuzzleHttp\Client;  

class HttpRequestHelper
{  

    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public static function sendRequest(string $method, string $url, array $options = []): array
    {  
        $client = new Client();  

        try {  
            $response = $client->request($method, $url, $options);  

            return [  
                'statusCode' => $response->getStatusCode(),  
                'body' => $response->getBody()->getContents(),  
            ];  
        } catch (Exception $e) {  
            return [  
                'error' => $e->getMessage(),  
            ];  
        }  
    }  
}