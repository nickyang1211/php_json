<?php  

namespace App\Http\Helpers;  

use GuzzleHttp\Client;  

class HttpRequestHelper  
{  
    public static function sendRequest(string $method, string $url, array $options = []): array
    {  
        $client = new Client();  

        try {  
            $response = $client->request($method, $url, $options);  

            return [  
                'statusCode' => $response->getStatusCode(),  
                'body' => $response->getBody()->getContents(),  
            ];  
        } catch (\Exception $e) {  
            return [  
                'error' => $e->getMessage(),  
            ];  
        }  
    }  
}