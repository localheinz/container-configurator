<?php

namespace TomPHP\ConfigServiceProvider\FileReader;

use TomPHP\ConfigServiceProvider\Exception\UnknownFileTypeException;
use TomPHP\ConfigServiceProvider\FileReader\FileReader;

final class ReaderFactory
{
    /**
     * @var string[]
     */
    private $config;

    /**
     * @var FileReader[]
     */
    private $readers = [];

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param mixed $filename
     *
     * @return FileReader
     */
    public function create($filename)
    {
        $readerClass = $this->getReaderClass($filename);

        if (!isset($this->readers[$readerClass])) {
            $this->readers[$readerClass] = new $readerClass();
        }

        return $this->readers[$readerClass];
    }

    /**
     * @param string $filename
     *
     * @return string
     */
    private function getReaderClass($filename)
    {
        $readerClass = null;

        foreach ($this->config as $extension => $className) {
            if ($this->endsWith($filename, $extension)) {
                $readerClass = $className;
                break;
            }
        }

        if ($readerClass === null) {
            throw UnknownFileTypeException::fromFileExtension(
                $filename,
                array_keys($this->config)
            );
        }

        return $readerClass;
    }

    /**
     * @param string $haystack
     * @param string $needle
     *
     * @return bool
     */
    private function endsWith($haystack, $needle)
    {
        return $needle === substr($haystack, -strlen($needle));
    }
}