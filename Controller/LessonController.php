<?php

namespace App\Controller;

use App\Request\Lesson\ActionRequest;
use App\Resources\ActionResource;
use App\Service\LessonService;

/**
 * Class LessonController
 * @package App\Controller
 */
class LessonController
{
    /**
     * @var LessonService
     */
    public $service;

    /**
     * LessonController constructor.
     * @param LessonService $service
     */
    public function __construct(LessonService $service)
    {
        $this->service = $service;
    }

    /**
     * Получение данных через API.
     *
     * @param ActionRequest $request
     * @param ActionResource $resource
     * @return string
     * @throws \App\Exceptions\ResponseException
     */
    public function action(ActionRequest $request, ActionResource $resource): string
    {
        $type = $request->params['returnType'];
        $category = $request->params['category'];

        return $resource->handle($this->service->getResponse($category), $type);
    }
}