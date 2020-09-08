<?php
namespace App\EventListener;

use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use JMS\Serializer\Exception\ObjectConstructionException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class ExceptionListener
 */
class ExceptionListener
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ExceptionListener constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        // get the exception object from the received event
        $exception = $event->getThrowable();

        if (!$this->isApiRequest($event)) {
            return;
        }

        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        $errorMessage = Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR];

        if ($exception instanceof NotFoundHttpException) {
            $statusCode = Response::HTTP_NOT_FOUND;
            $errorMessage = $this->parseNotFoundError($exception->getMessage());
        } elseif ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
            $errorMessage = $exception->getMessage();
        } elseif ($exception instanceof AuthenticationException) {
            $statusCode = Response::HTTP_UNAUTHORIZED;
            $errorMessage = $exception->getMessage();
        } elseif ($exception instanceof AccessDeniedException) {
            $statusCode = Response::HTTP_FORBIDDEN;
            $errorMessage = Response::$statusTexts[Response::HTTP_FORBIDDEN];
        } elseif ($exception instanceof ForeignKeyConstraintViolationException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
            $errorMessage = "Not possible operation with dependent entities";
        } elseif ($exception instanceof UniqueConstraintViolationException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
            $errorMessage = "Entity has not unique values";
        } elseif ($exception instanceof ObjectConstructionException) {
            $statusCode = Response::HTTP_BAD_REQUEST;
            $errorMessage = $exception->getMessage();
        }

        $this->logError($statusCode, $exception);


        $content = ['error' => ['code' => $statusCode, 'message' => $errorMessage]];
        $response = new JsonResponse($content, $statusCode);

        // set the modified response object to the event
        $event->setResponse($response);
    }

    /**
     * @param ExceptionEvent $event
     *
     * @return bool
     */
    private function isApiRequest(ExceptionEvent $event): bool
    {
        $url = $event->getRequest()->getPathInfo();
        preg_match('/^\/api\/v1\//', $url, $matches);

        return (bool)$matches;
    }

    /**
     * @param string $errorMessage
     *
     * @return string
     */
    private function parseNotFoundError(string $errorMessage)
    {
        preg_match('/^([\w]+)\\\\([\w]+)\\\\([\w]+) object (not found.)/u', $errorMessage, $matches);
        if (isset($matches[4])) {
            return trim("{$matches[3]} {$matches[4]}");
        } else {
            return $errorMessage;
        }
    }

    /**
     * @param int        $statusCode
     * @param \Throwable $error
     */
    private function logError(int $statusCode, \Throwable $error): void
    {
        if ($statusCode === Response::HTTP_INTERNAL_SERVER_ERROR) {
            $this->logger->error(
                $error->getMessage(),
                ['file' => $error->getFile(), 'line' => $error->getLine()]
            );
        }
    }
}
