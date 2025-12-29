<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->descriptiveResponseMethods();
    }

    /**
     * Format the response and return
     */
    protected function descriptiveResponseMethods()
    {
        $instance = $this;
        Response::macro(
            'ok',
            function ($data = [], $message = 'Request has been Processed Successfully.') use ($instance) {
                return $instance->handleResponse($data, $message, 200);
            }
        );

        Response::macro(
            'created',
            function ($data = [], $message = 'Record has been Successfully Created.') use ($instance) {
                return $instance->handleResponse($data, $message, 201);
            }
        );

        Response::macro(
            'noContent',
            function ($data = [], $message = 'Server has Successfully Fulfilled the Request.') use ($instance) {
                return $instance->handleResponse([], $message, 204);
            }
        );

        Response::macro('badRequest', function ($errors = [], $message = 'Validation Failure.') use ($instance) {
            return $instance->handleResponse($errors, $message, 400);
        });

        Response::macro('unauthorized', function ($errors = [], $message = 'User unauthorized.') use ($instance) {
            return $instance->handleResponse($errors, $message, 401);
        });

        Response::macro('forbidden', function ($errors = [], $message = 'Access denied.') use ($instance) {
            return $instance->handleResponse($errors, $message, 403);
        });

        Response::macro('notFound', function ($errors = [], $message = 'Resource not found.') use ($instance) {
            return $instance->handleResponse($errors, $message, 404);
        });

        Response::macro(
            'unprocessableContent',
            function ($errors = [], $message = 'Unprocessable Content.') use ($instance) {
                return $instance->handleResponse($errors, $message, 422);
            }
        );

        Response::macro(
            'internalServerError',
            function ($errors = [], $message = 'Internal Server Error.') use ($instance) {
                return $instance->handleResponse($errors, $message, 500);
            }
        );
    }

    /**
     * handle response
     */
    public function handleResponse($data, $message, $status)
    {
        $response = [
            'success' => ($status <= 300 ) ? true : false,
            'message' => $message
        ];

        if (!empty($data)) {
             $response['data'] = $data;
        }

        if (!is_array($data) && class_basename($data) == 'AnonymousResourceCollection' && !empty($data)) {
            $response['data'] = $response['data']->resource;
        }  else if(
            isset($response['data']) && !is_object($response['data']) && (isset($data['persons']) && isset($data['patients']) 
            &&  isset($data['studies']) &&  isset($data['organizations'])
            &&  isset($data['events']) || isset($data['has_incomplete_procedures']) || isset($data['unread_count']) 
            || isset($data['can_log_sae']))) {
            foreach($data as $key => $entity) {
                $response['data'][$key] = in_array($key, ['has_incomplete_procedures', 'unread_count', 'can_log_sae'])
                    ? $data[$key]
                    : [];
                if (!is_array($entity) && class_basename($entity) == 'AnonymousResourceCollection' && !empty($entity)) {
                    $response['data'][$key] = $entity->resource;
                }
            }
        }
        return Response::json($response, $status);
    }
}
