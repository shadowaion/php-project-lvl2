<?php

namespace php\project\lvl2\tests;

use PHPUnit\Framework\TestCase;

use function php\project\lvl2\src\Differ\genDiff;
use function php\project\lvl2\src\Parsers\parseFile;

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

        $parsedJSONFileOne = parseFile($this->jsonOne);
        $parsedJSONFileTwo = parseFile($this->jsonTwo);

        self::assertEquals($plainData, genDiff($parsedJSONFileOne, $parsedJSONFileTwo));
    }

    public function testGenDiffYAMLPlain()
    {
        $plainData = file_get_contents($this->getFilePath($this->expectedDataFile));

        $parsedYAMLFileOne = parseFile($this->yamlOne);
        $parsedYAMLFileTwo = parseFile($this->yamlTwo);

        self::assertEquals($plainData, genDiff($parsedYAMLFileOne, $parsedYAMLFileTwo));
    }
}