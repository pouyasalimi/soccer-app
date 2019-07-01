<?php

/**
 * custom json response class for better output messages format
 */
namespace App\Http\Response;

use Illuminate\Http\Response;

class Json {
    private $data;

    function __construct() {
        $this->data['isSuccessful'] = true;
        $this->data['payload'] = null;
        $this->data['message'] = '';
        $this->data['errors'] = null;
        $this->data['statusCode'] = 200;
    }

    public function successfulStatus($data, $message = '', $statusCode = Response::HTTP_OK, $headers = []) {
        $this->data['isSuccessful'] = true;
        $this->data['payload'] = $data;
        $this->data['message'] = $message;
        $this->data['statusCode'] = $statusCode;

        return response()->json($this->data, $statusCode)->withHeaders($headers);

    }

    public function failureStatus($errors, $message = '', $statusCode = Response::HTTP_BAD_REQUEST, $headers = []) {
        $this->data['isSuccessful'] = false;
        $this->data['message'] = $message;
        $this->data['errors'] = $errors;
        $this->data['statusCode'] = $statusCode;
        return response()->json($this->data, $statusCode)->withHeaders($headers);
    }
}
