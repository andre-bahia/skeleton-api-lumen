<?php
namespace App\Services;

use Dingo\Api\Routing\Helpers;
use Dingo\Api\Exception\ValidationHttpException;

class Service
{
    use Helpers;

    protected function errorBadRequest($messages)
    {
       
        $result = [];
        
        if ($messages) {
            foreach ($messages as $field => $errors) {
                foreach ($errors as $error) {
                    $result[] = [
                        'field' => $field,
                        'code' => $error,
                    ];
                }
            }
        }

        throw new ValidationHttpException($result);
    }

    protected function success($data)
    {
        return response()->json([
            "success" => true,
            "status_code" => 200,
            "data" => $data 
        ]);
    }

    protected function error($message, $code = 500)
    {
        return response()->json([
            "success" => false,
            "status_code" => $code,
            "data" => $message 
        ]);        
    }
}