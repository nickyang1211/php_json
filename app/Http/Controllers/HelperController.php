<?php

namespace App\Http\Controllers;
use App\Http\Helpers\HttpRequestHelper;

use Illuminate\Http\Request;

class HelperController extends Controller
{
    //
    public function helper(Request $request) {  
        $method = $request->input('method', 'GET');  
        $url = $request->input('url');  
        $options = $request->input('options', []);  
        
        // 调用 Helper 函数来发送请求  
        $result = HttpRequestHelper::sendRequest($method, $url, $options);  
        
        if (isset($result['error'])) {  
            return response()->json(['error' => $result['error']], 500);  
        }  
        
        return response()->json($result, $result['statusCode']);  
    }
}
