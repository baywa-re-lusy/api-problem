<?php

namespace BayWaReLusy\ApiProblem;

use Laminas\ApiTools\ApiProblem\ApiProblem;

class Exception extends \Exception
{
    public const TYPE_BAD_REQUEST           = 'bad_request';
    public const TYPE_UNPROCESSABLE_ENTITY  = 'invalid_data';
    public const TYPE_NOT_FOUND             = 'not_found';
    public const TYPE_FORBIDDEN             = 'forbidden';
    public const TYPE_CONFLICT              = 'conflict';
    public const TYPE_GATEWAY_TIMEOUT       = 'gateway_timeout';
    public const TYPE_UNAUTHORIZED          = 'unauthorized';
    public const TYPE_SERVICE_UNAVAILABLE   = 'service_unavailable';
    public const TYPE_INTERNAL_SERVER_ERROR = 'internal_server_error';
    public const TYPE_NOT_IMPLEMENTED       = 'not_implemented';

    protected const TYPE_TO_CODE_MAP =
        [
            self::TYPE_BAD_REQUEST           => 400,
            self::TYPE_UNPROCESSABLE_ENTITY  => 422,
            self::TYPE_NOT_FOUND             => 404,
            self::TYPE_FORBIDDEN             => 403,
            self::TYPE_CONFLICT              => 409,
            self::TYPE_GATEWAY_TIMEOUT       => 504,
            self::TYPE_UNAUTHORIZED          => 401,
            self::TYPE_SERVICE_UNAVAILABLE   => 503,
            self::TYPE_INTERNAL_SERVER_ERROR => 500,
            self::TYPE_NOT_IMPLEMENTED       => 501,
        ];

    public const CODE_TO_TYPE_MAP =
        [
            400 => self::TYPE_BAD_REQUEST,
            422 => self::TYPE_UNPROCESSABLE_ENTITY,
            404 => self::TYPE_NOT_FOUND,
            403 => self::TYPE_FORBIDDEN,
            409 => self::TYPE_CONFLICT,
            504 => self::TYPE_GATEWAY_TIMEOUT,
            401 => self::TYPE_UNAUTHORIZED,
            503 => self::TYPE_SERVICE_UNAVAILABLE,
            500 => self::TYPE_INTERNAL_SERVER_ERROR,
            501 => self::TYPE_NOT_IMPLEMENTED,
        ];

    public const ERROR_TYPE_LABELS =
        [
            self::TYPE_BAD_REQUEST           => 'Bad Request',
            self::TYPE_UNPROCESSABLE_ENTITY  => 'Unprocessable Entity',
            self::TYPE_NOT_FOUND             => 'Not Found',
            self::TYPE_FORBIDDEN             => 'Forbidden',
            self::TYPE_CONFLICT              => 'Conflict',
            self::TYPE_GATEWAY_TIMEOUT       => 'Gateway Timeout',
            self::TYPE_UNAUTHORIZED          => 'Unauthorized',
            self::TYPE_SERVICE_UNAVAILABLE   => 'Service Unavailable',
            self::TYPE_INTERNAL_SERVER_ERROR => 'Internal Server Error',
            self::TYPE_NOT_IMPLEMENTED       => 'Not Implemented',
        ];

    protected string $type;
    protected string $errorMessage;

    public function __construct(string $type, string $errorMessage)
    {
        parent::__construct($errorMessage);

        $this->type         = $type;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @param string $errorMessage
     * @return Exception
     */
    public function setErrorMessage(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @param string $type
     * @return Exception
     */
    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return ApiProblem The Exception transformed into an ApiProblem instance.
     */
    public function getApiProblem(): ApiProblem
    {
        return new ApiProblem(
            self::TYPE_TO_CODE_MAP[$this->getType()],
            $this->getErrorMessage(),
            'https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html',
            self::ERROR_TYPE_LABELS[$this->getType()]
        );
    }
}
