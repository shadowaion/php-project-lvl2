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
    private $nestedJsonOne = __DIR__ . "/fixtures/fileNestedJSON1.json";
    private $nestedJsonTwo = __DIR__ . "/fixtures/fileNestedJSON2.json";
    private $nestedYamlOne = __DIR__ . "/fixtures/fileNestedYAML1.yml";
    private $nestedYamlTwo = __DIR__ . "/fixtures/fileNestedYAML2.yml";
    private $expectedDataFile = "plain.txt";
    private $expectedNestedDataFile = "nested.txt";
    private $expectedPlainFormatNestedDataFile = "nestedPlainFormatter.txt";
    

    private function getFilePath($name)
    {
        return $this->path . $name;
    }

    public function testGenDiffJSONPlain()
    {
        $plainData = file_get_contents($this->getFilePath($this->expectedDataFile));

        $genDiff = genDiff($this->jsonOne, $this->jsonTwo);

        self::assertEquals($plainData, $genDiff);
    }

    public function testGenDiffYAMLPlain()
    {
        $plainData = file_get_contents($this->getFilePath($this->expectedDataFile));

        $genDiff = genDiff($this->yamlOne, $this->yamlTwo);

        self::assertEquals($plainData, $genDiff);
    }

    public function testGenDiffJSONNested()
    {
        $nestedData = file_get_contents($this->getFilePath($this->expectedNestedDataFile));

        $genDiff = genDiff($this->nestedJsonOne, $this->nestedJsonTwo, "stylish");

        self::assertEquals($nestedData, $genDiff);
    }

    public function testGenDiffYAMLNested()
    {
        $nestedData = file_get_contents($this->getFilePath($this->expectedNestedDataFile));

        $genDiff = genDiff($this->nestedYamlOne, $this->nestedYamlTwo, "stylish");

        self::assertEquals($nestedData, $genDiff);
    }

    public function testGenDiffJSONNestedPlainFormat()
    {
        $nestedData = file_get_contents($this->getFilePath($this->expectedPlainFormatNestedDataFile));

        $genDiff = genDiff($this->nestedJsonOne, $this->nestedJsonTwo, "plain");

        self::assertEquals($nestedData, $genDiff);
    }

    public function testGenDiffYAMLNestedPlainFormat()
    {
        $nestedData = file_get_contents($this->getFilePath($this->expectedPlainFormatNestedDataFile));

        $genDiff = genDiff($this->nestedYamlOne, $this->nestedYamlTwo, "plain");

        self::assertEquals($nestedData, $genDiff);
    }

    // public function testGenDiffJSONNestedJsonFormat()
    // {
    //     $nestedData = file_get_contents($this->getFilePath($this->expectedPlainFormatNestedDataFile));

    //     $genDiff = genDiff($this->nestedJsonOne, $this->nestedJsonTwo, "json");

    //     self::assertEquals($nestedData, $genDiff));
    // }

    // public function testGenDiffYAMLNestedJsonFormat()
    // {
    //     $nestedData = file_get_contents($this->getFilePath($this->expectedPlainFormatNestedDataFile));

    //     $genDiff = genDiff($this->nestedYamlOne, $this->nestedYamlTwo, "json");

    //     self::assertEquals($nestedData, $genDiff));
    // }
}