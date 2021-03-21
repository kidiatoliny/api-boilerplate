<?php

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

if (!function_exists('error')) {
    /**
     * Error
     * @param Exception|Throwable $error
     * @return \Illuminate\Http\Response
     */
    function error($error)
    {
        return response()->json(
            [
                'status' => Response::HTTP_NOT_FOUND,
                'success' => false,
                'message' => $error->getMessage()
            ],
            Response::HTTP_NOT_FOUND,
        );
    }
}

if (!function_exists('updated')) {
    /**
     * Update succesfuly message
     *
     * @param String $entity
     * @return \Illuminate\Http\Response
     */
    function updated($entity)
    {
        return response()->json(
            [
                'message' => "Recurso foi atualizado com sucesso",
                'status' => 200,
                'success' => true,
                'data' => $entity
            ],
            200
        );
    }
}

if (!function_exists('deleted')) {
    /**
     * Deleted succesfuly message
     *
     * @param String $entity
     * @return \Illuminate\Http\Response
     */
    function deleted()
    {
        return response()->json(
            [
                'message' => "Recurso foi eliminado com succeso",
                'status' => 200,
                'success' => true
            ],
            200
        );
    }
}

if (!function_exists('created')) {
    /**
     * Succesfully message
     *
     * @param String $entity
     * @return \Illuminate\Http\Response
     */
    function created($entity)
    {
        return response()->json(
            [
                'message' => "Recurso foi criado com sucesso",
                'status' => 201,
                'success' => true,
                'data' => $entity
            ],
            201
        );
    }
}


if (!function_exists('unauthorized')) {
    /**
     * Unauthorized message
     *
     *@return \Illuminate\Http\Response
     */
    function unauthorized()
    {
        return response()->json(
            [
                'status' => 401,
                'success' => false,
                'message' => "Sem permissão, contate o Administrador do Sistema"
            ],
            401
        );
    }
}

if (!function_exists('invalidCredentials')) {
    /**
     * invalidCredentials message
     *
     *@return \Illuminate\Http\Response
     */
    function invalidCredentials()
    {
        return response()->json(
            [
                'status' => 400,
                'success' => false,
                'message' => "Credências Inválidas"
            ],
            400
        );
    }
}
if (!function_exists('getData')) {
    /**
     * Get all response
     * @param  \Illuminate\Http\Response $entity
     * @return \Illuminate\Http\Response
     */
    function getData($entity)
    {
        return response()->json(
            [
                'success' => true,
                'message' => 'Recurso carregado com successo',
                'status' => Response::HTTP_OK,
                'data' => $entity
            ],
            Response::HTTP_OK
        );
    }
}
if (!function_exists('formatDate')) {
    /**
     * Format Date
     * @param Date $date
     */
    function formatDate($date)
    {
        if ($date instanceof \DateTime) {
            return date_format($date, 'd-M-Y');
        }
        return null;
    }
}

if (!function_exists('validateJson')) {
    /**
     * Validate Json data
     *
     * @param Request $request
     * @return Request
     */
    function validJson($request)
    {

        $response = json_decode($request->getContent(), true);


        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }
        return $response;
    }
}
if (!function_exists('badRequest')) {
    /**
     * Bad Json Response
     *
     * @return HTTP_BAD_REQUEST
     */
    function badRequest($message)
    {

        return response()->json(
            [
                'status' => Response::HTTP_BAD_REQUEST,
                'success' => false,
                'message' => $message,
            ],
            Response::HTTP_BAD_REQUEST
        );
    }
}

if (!function_exists('validationError')) {
    function validationError(MessageBag $messageBag)
    {
        $apiMessage = [];
        foreach ($messageBag->messages() as $key => $messages) {


            if (is_array($messages)) {
                foreach ($messages as $message) :
                    $apiMessage[] = [$key => $message];
                endforeach;
            } else {
                $apiMessage[] = $messages;
            }
        }

        return response()->json(
            [
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'success' => false,
                'message' => 'Erro de validação',
                'error' => [
                    "code" => 'validation_failed',
                    "message" => 'Erro de validação ',
                    "fields" => $apiMessage
                ],
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}

if (!function_exists('validateRequest')) {
    function validateRequest($request, $rules = [])
    {
        $validator = Validator::make(
            $request->all(),
            $rules
        );
        return $validator;
    }
}

if (!function_exists('notFound')) {
    function notFound()
    {

        return response()->json(
            [
                'status' => Response::HTTP_NOT_FOUND,
                'success' => false,
                'message' => "Recurso não encontrado",
            ],
            Response::HTTP_NOT_FOUND
        );
    }
}
