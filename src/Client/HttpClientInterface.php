<?php

declare(strict_types=1);

namespace Aleksandr\SberbankAcquiring\Client;

use Aleksandr\SberbankAcquiring\Exceptions\HttpClientException;
use Aleksandr\SberbankAcquiring\Exceptions\NetworkException;

interface HttpClientInterface
{

    /**
     * HTTP GET
     *
     * @var string
     */
    public const METHOD_GET = 'GET';

    /**
     * HTTP POST
     *
     * @var string
     */
    public const METHOD_POST = 'POST';

    /**
     * Вызов API
     *
     * @param string $uri    URI
     * @param string $method Метод HTTP
     * @param array $data    Данные запроса
     * @param array $headers Хэдеры
     *
     * @return string
     * @throws NetworkException
     * @throws HttpClientException
     * @throws \InvalidArgumentException
     */
    public function request(
        string $uri,
        string $method = self::METHOD_POST,
        array $data = [],
        array $headers = []
    ): string;
}
