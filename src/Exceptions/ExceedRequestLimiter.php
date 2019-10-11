<?php

namespace Billplz\Exceptions;

use Laravie\Codex\Exceptions\HttpException;

class ExceedRequestLimiter extends HttpException
{
    /**
     * Construct a new HTTP exception.
     *
     * @param \Psr\Http\Message\ResponseInterface|\Laravie\Codex\Contracts\Response  $response
     * @param string  $message
     * @param \Exception|null  $previous
     * @param int  $code
     */
    public function __construct(
        $response,
        ?string $message = null,
        ?Exception $previous = null,
        int $code = 0
    ) {
        parent::__construct(
            $response, $message ?: 'Too many requests', $previous, 419
        );

        $this->setResponse($response);
    }

    /**
     * Get time remaining before rate limit reset.
     *
     * @return int
     */
    public function timeRemaining(): int
    {
        $value = $this->response->getHeaderLine('RateLimit-Reset');

        return ! \in_array($value, ['', 'unlimited']) ? (int) $value : 0;
    }
}
