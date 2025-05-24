<?php

namespace Modules\Asset\Response;

use Illuminate\Http\JsonResponse;

trait WithResponse
{
    /**
     * Generates a response for successful login
     *
     * @param string $token The authentication token generated after successful login
     * @return JsonResponse The JSON response containing the token
     */
    protected function loginResponse(string $token): JsonResponse
    {
        return $this->success(
            "Login token generated successfully",
            [
                "token" => $token,
            ],
            201
        );
    }

    /**
     * Generates a response for successful user registration
     *
     * @return JsonResponse The JSON response containing success message
     */
    protected function assetCreatedResponse(): JsonResponse
    {
        return $this->success("Asset created successfully", status: 201);
    }

    /**
     * Generates a response for validation errors
     *
     * @param string $message The validation error message
     * @return JsonResponse The JSON response containing the error message
     */
    protected function validationError(
        string $message = "Validation failed"
    ): JsonResponse {
        return $this->error($message, 422);
    }

    /**
     * Generates a response for unauthorized requests
     *
     * @param string $message The unauthorized error message
     * @return JsonResponse The JSON response containing the error message
     */
    protected function unauthorized(
        string $message = "Unauthorized"
    ): JsonResponse {
        return $this->error($message, 401);
    }

    /**
     * Generates a successful response
     *
     * @param string $message The success message
     * @param mixed $data Optional data to include in the response
     * @param int $status HTTP status code for the response
     * @return JsonResponse The JSON response with success status, message and optional data
     */
    private function success(
        string $message,
        mixed $data = null,
        int $status = 200
    ): JsonResponse {
        return response()->json(
            array_filter([
                "status" => "success",
                "message" => $message,
                "data" => $data,
            ]),
            $status
        );
    }

    /**
     * Generates an error response
     *
     * @param string $message The error message
     * @param int $status HTTP status code for the response
     * @return JsonResponse The JSON response with error status and message
     */
    private function error(string $message, int $status = 400): JsonResponse
    {
        return response()->json(
            [
                "status" => "error",
                "message" => $message,
            ],
            $status
        );
    }
}
