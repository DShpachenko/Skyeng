<?php

namespace App\Resources;

use SimpleXMLElement;

/**
 * Class ActionResource
 * @package App\Resources
 */
class ActionResource
{
    /**
     * @var SimpleXMLElement
     */
    public $xml;

    /**
     * ActionResource constructor.
     */
    public function __construct()
    {
        $this->xml = new SimpleXMLElement('<root/>');
    }

    /**
     * Возврат результата.
     *
     * @param $data
     * @param $type
     * @return string
     */
    public function handle($data, $type): string
    {
        return ($type === 'json') ? $this->toJson($data) : $this->toXml($data);
    }

    /**
     * Перевод данных в формат Json.
     *
     * @param $data
     * @return string
     */
    private function toJson($data): string
    {
        return json_encode($data);
    }

    /**
     * Перевод данных в формат Xml.
     *
     * @param $data
     * @return string
     */
    private function toXml($data): string
    {
        array_walk_recursive($data, array ($this->xml, 'addChild'));

        return $this->xml->asXML();
    }
}