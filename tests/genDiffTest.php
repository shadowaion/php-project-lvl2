<?php

namespace php\project\lvl2\tests;

use PHPUnit\Framework\TestCase;

use function php\project\lvl2\src\Differ\genDiff;
use function php\project\lvl2\src\Differ\stylish;
use function php\project\lvl2\src\Parsers\parseFile;

class genDiffTest extends TestCase
{
    private $path = __DIR__ . "/fixtures/";
    private $jsonOne = __DIR__ . "/fixtures/fileJSON1.json";
    private $jsonTwo = __DIR__ . "/fixtures/fileJSON2.json";
    private $yamlOne = __DIR__ . "/fixtures/fileYAML1.yml";
    private $yamlTwo = __DIR__ . "/fixtures/fileYAML2.yml";
    private $nestedJsonOne = __DIR__ . "/fixtures/fileNestedJSON1.json";
    private $nestedJsonTwo = __DIR__ . "/fixtures/fileNestedJSON2.json";
    private $nestedYamlOne = __DIR__ . "/fixtures/fileNestedYAML1.yml";
    private $nestedYamlTwo = __DIR__ . "/fixtures/fileNestedYAML2.yml";
    private $expectedDataFile = "plain.txt";
    private $expectedNestedDataFile = "nested.txt";

    private function getFilePath($name)
    {
        return $this->path . $name;
    }

    public function testGenDiffJSONPlain()
    {
        $plainData = file_get_contents($this->getFilePath($this->expectedDataFile));

        $parsedJSONFileOne = parseFile($this->jsonOne);
        $parsedJSONFileTwo = parseFile($this->jsonTwo);

        $genDiff = genDiff($parsedJSONFileOne, $parsedJSONFileTwo);

        self::assertEquals($plainData, stylish($genDiff));
    }

    public function testGenDiffYAMLPlain()
    {
        $plainData = file_get_contents($this->getFilePath($this->expectedDataFile));

        $parsedYAMLFileOne = parseFile($this->yamlOne);
        $parsedYAMLFileTwo = parseFile($this->yamlTwo);

        $genDiff = genDiff($parsedYAMLFileOne, $parsedYAMLFileTwo);

        self::assertEquals($plainData, stylish($genDiff));
    }

    public function testGenDiffJSONNested()
    {
        $nestedData = file_get_contents($this->getFilePath($this->expectedNestedDataFile));

        $parsedJSONFileOne = parseFile($this->nestedJsonOne);
        $parsedJSONFileTwo = parseFile($this->nestedJsonTwo);

        $genDiff = genDiff($parsedJSONFileOne, $parsedJSONFileTwo);

        self::assertEquals($nestedData, stylish($genDiff));
    }

    public function testGenDiffYAMLNested()
    {
        $nestedData = file_get_contents($this->getFilePath($this->expectedNestedDataFile));

        $parsedYAMLFileOne = parseFile($this->nestedYamlOne);
        $parsedYAMLFileTwo = parseFile($this->nestedYamlTwo);

        $genDiff = genDiff($parsedYAMLFileOne, $parsedYAMLFileTwo);

        self::assertEquals($nestedData, stylish($genDiff));
    }
}