<?php

namespace App\Service;

use App\Exceptions\ResponseException;
use App\Helpers\HttpCurl;
use Psr\Log\LoggerInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Class LessonService
 * @package App\Service
 */
class LessonService
{
    public const CACE_LESSON_CATEGORY_SUFFIX = 'lesons';

    /**
     * @var CacheItemPoolInterface
     */
    public $cache;

    /**
     * @var LoggerInterface
     */
    public $logger;

    /**
     * @var HttpCurl
     */
    public $httpCurl;

    /**
     * LessonService constructor.
     * @param CacheItemPoolInterface $cache
     * @param LoggerInterface $logger
     * @param HttpCurl $httpCurl
     */
    public function __construct(CacheItemPoolInterface $cache, LoggerInterface $logger, HttpCurl $httpCurl)
    {
        $this->cache = $cache;
        $this->logger = $logger;
        $this->httpCurl = $httpCurl;
    }

    /**
     * Получение ответа.
     *
     * @param $category
     * @return array
     * @throws ResponseException
     */
    public function getResponse($category): array
    {
        try {
            $input = ['categoryId' => $category, ''];
            $cacheKey = $this->getCacheKey(self::CACE_LESSON_CATEGORY_SUFFIX, $input);

            $cacheItem = $this->cache->getItem($cacheKey);

            if ($cacheItem->isHit()) {
                return $cacheItem->get();
            }

            $data = $this->httpCurl->get($input);

            if (!empty($data)) {
                $cacheItem
                    ->set($data)
                    ->expiresAt(
                        (new \DateTime())->modify('+1 day')
                    );

                return $data;
            }
        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
        }

        throw new ResponseException('Error');
    }

    /**
     * Получение ключа канала кэша.
     *
     * @param $suffix
     * @param $input
     * @return string
     */
    private function getCacheKey($suffix, $input): string
    {
        return $suffix.json_encode($input);
    }
}