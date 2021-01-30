<?php

namespace php\project\lvl2\tests;

use PHPUnit\Framework\TestCase;

use function php\project\lvl2\src\Differ\genDiff;

class genDiffTest extends TestCase
{
    private $path = __DIR__ . "/fixtures/";
    private $filePathOne = __DIR__ . "/fixtures/file1.json";
    private $filePathTwo = __DIR__ . "/fixtures/file2.json";
    private $expectedDataFile = "plain.txt";

    private function getFilePath($name)
    {
        return $this->path . $name;
    }

    public function testGenDiffPlain()
    {
        $plainData = file_get_contents($this->getFilePath($this->expectedDataFile));

        self::assertEquals($plainData, genDiff($this->filePathOne, $this->filePathTwo));
    }
}