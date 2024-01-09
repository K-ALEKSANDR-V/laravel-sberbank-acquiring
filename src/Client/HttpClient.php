<?php

declare(strict_types=1);

namespace Aleksandr\SberbankAcquiring\Client;

use Aleksandr\SberbankAcquiring\Client\Curl\CurlInterface;
use Aleksandr\SberbankAcquiring\Exceptions\HttpClientException;
use Aleksandr\SberbankAcquiring\Exceptions\NetworkException;

class HttpClient implements HttpClientInterface
{
    /**
     * @var CurlInterface
     */
    private $curl;

    /**
     * @var array
     */
    private $curlOptions;

    /**
     * HttpClient constructor.
     *
     * @param CurlInterface $curl
     * @param array $curlOptions Опции Curl
     */
    public function __construct(CurlInterface $curl, array $curlOptions = [])
    {
        $this->curl = $curl;
        $this->curlOptions = $curlOptions;
    }

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
    ): string {
        if (empty($uri)) {
            throw new \InvalidArgumentException('Uri must be a non-empty string');
        }

        $this->curl->initialize();

        if ($method === self::METHOD_GET) {
            $uri = $uri . '?' . http_build_query($data);
            $this->curl->setHeader(['Content-type' => 'application/json']);
        } elseif ($method === self::METHOD_POST) {
            $this->curl->setOption(CURLOPT_POST, 1);
            $this->curl->setOption(CURLOPT_POSTFIELDS, http_build_query($data));
            $this->curl->setHeader(['Content-type' => 'application/x-www-form-urlencoded']);
        } else {
            throw new \InvalidArgumentException('Valid methods are: GET, POST');
        }

        $this->curl->setOptions($this->curlOptions);
        $this->curl->setHeader($headers);
        $this->curl->setOption(CURLOPT_RETURNTRANSFER, 1);
        $this->curl->setOption(CURLOPT_URL, $uri);
        $this->curl->setOption(CURLOPT_SSL_VERIFYHOST, 0);
        $this->curl->setOption(CURLOPT_SSL_VERIFYPEER, 0);

        $response = $this->curl->execute();

        if ($response === false) {
            $error = $this->curl->getError();
            $errorCode = $this->curl->getErrno();
            // Если CURL не вернул ответ КАВ НАЧАЛО
//            throw new NetworkException("Curl error: $error ($errorCode)");
            $errorMessage = "Curl error: $error ($errorCode)";
            return json_encode(['unavailable' => true, 'errorMessage' => $errorMessage, 'errorCode' => $errorCode]);
            // КАВ КОНЕЦ
        }

        $statusCode = $this->curl->getInfo(CURLINFO_RESPONSE_CODE);
        if ($statusCode !== 200) {
            throw new HttpClientException("$method request resulted in a $statusCode code response");
        }

        $this->curl->close();

        return $response;
    }
}
