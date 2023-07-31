<?php

namespace App\Application\EventListener;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class ExceptionSubscriber
{
//    private Sentry $sentry;
//
//    public function __construct(Sentry $sentry)
//    {
//        $this->sentry = $sentry;
//    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $statusCode = $this->getStatusCode($exception);
        $response->setStatusCode($statusCode);

        $message = [$exception->getMessage()];

//        if ($exception instanceof AbstractException) {
//            if ('' === $exception->getMessageKey()) {
//                $message = [$exception->getMessageKey() => $exception->getMessage()];
//            }
//        }

        if (is_array(json_decode($exception->getMessage(), true))) {
            $message = json_decode($exception->getMessage());
        }

        $response->setContent(json_encode([
            'message' => $message,
            'code' => $statusCode,
            'type' => var_export(get_class($exception), true),
        ]));

//        if (!in_array($statusCode, [401, 403, 404]) && !($exception instanceof AbstractException)) {
//            $this->sentry->captureException($exception);
//        }

        $event->setResponse($response);
    }

    private function getStatusCode(\Throwable $exception): int
    {
        $exceptionCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($exception instanceof NotFoundHttpException) {
            $exceptionCode = Response::HTTP_NOT_FOUND;
        }

        if ($exception instanceof NotAcceptableHttpException) {
            $exceptionCode = Response::HTTP_NOT_ACCEPTABLE;
        }

        if ($exception instanceof BadRequestHttpException || $exception->getPrevious() instanceof BadRequestHttpException) {
            $exceptionCode = Response::HTTP_BAD_REQUEST;
        }

//        if ($exception instanceof DataTransferObjectError) {
//            $exceptionCode = Response::HTTP_UNPROCESSABLE_ENTITY;
//        }

        if ($exception instanceof AccessDeniedHttpException) {
            $exceptionCode = Response::HTTP_FORBIDDEN;
        }

        if ($exception instanceof TooManyRequestsHttpException) {
            $exceptionCode = Response::HTTP_TOO_MANY_REQUESTS;
        }

        if (false !== strpos($exception->getMessage(), 'Expired JWT Token')
            || false !== strpos($exception->getMessage(), 'Invalid JWT Token')
            || false !== strpos($exception->getMessage(), 'Unable to verify the given JWT ')
            || false !== strpos($exception->getMessage(), 'JwtAuthenticator::getCredentials()')
        ) {
            $exceptionCode = Response::HTTP_UNAUTHORIZED;
        }

        return $exceptionCode;
    }
}
