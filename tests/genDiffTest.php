<?php

namespace php\project\lvl2\tests;

use PHPUnit\Framework\TestCase;

use function php\project\lvl2\src\Differ\genDiff;

class genDiffTest extends TestCase
{
    private $path = __DIR__ . "/fixtures/";
    private $jsonOne = __DIR__ . "/fixtures/fileJSON1.json";
    private $jsonTwo = __DIR__ . "/fixtures/fileJSON2.json";
    private $yamlOne = __DIR__ . "/fixtures/fileYAML1.yml";
    private $yamlTwo = __DIR__ . "/fixtures/fileYAML2.yml";
    private $expectedDataFile = "plain.txt";

    private function getFilePath($name)
    {
        return $this->path . $name;
    }

    public function testGenDiffJSONPlain()
    {
        $plainData = file_get_contents($this->getFilePath($this->expectedDataFile));

        self::assertEquals($plainData, genDiff($this->jsonOne, $this->jsonTwo));
    }

    public function testGenDiffYAMLPlain()
    {
        $plainData = file_get_contents($this->getFilePath($this->expectedDataFile));

        self::assertEquals($plainData, genDiff($this->yamlOne, $this->yamlTwo));
    }
}