<?php

namespace TomPHP\ConfigServiceProvider;

use TomPHP\ConfigServiceProvider\Exception\FileNotFoundException;
use TomPHP\ConfigServiceProvider\Exception\InvalidConfigException;

final class PHPFileReader implements FileReader
{
    private $filename;

    public function read($filename)
    {
        $this->filename = $filename;

        $this->assertFileExists();

        $config = include $this->filename;

        $this->assertConfigIsValid($config);

        return $config;
    }

    private function assertFileExists()
    {
        if (!file_exists($this->filename)) {
            throw FileNotFoundException::fromFileName($this->filename);
        }
    }

    private function assertConfigIsValid($config)
    {
        if (!is_array($config)) {
            throw InvalidConfigException::fromPHPFileError($this->filename);
        }
    }
}
