<?php

namespace php\project\lvl2\tests;

use PHPUnit\Framework\TestCase;

use function php\project\lvl2\src\Differ\genDiff;

class genDiffTest extends TestCase
{
    private $path = __DIR__ . "/fixtures/";
    private $jsonOne = "fileJSON1.json";
    private $jsonTwo = "fileJSON2.json";
    private $yamlOne = "fileYAML1.yml";
    private $yamlTwo = "fileYAML2.yml";
    private $nestedJsonOne = "fileNestedJSON1.json";
    private $nestedJsonTwo = "fileNestedJSON2.json";
    private $nestedYamlOne = "fileNestedYAML1.yml";
    private $nestedYamlTwo = "fileNestedYAML2.yml";
    private $expectedDataFile = "plain.txt";
    private $expectedNestedDataFile = "nested.txt";
    private $expectedPlainFormatNestedDataFile = "nestedPlainFormatter.txt";
    private $expectedJsonFormatNestedDataFile = "jsonFormat.txt";
    

    private function getFilePath($name)
    {
        return $this->path . $name;
    }

    public function testGenDiffJSONPlain()
    {
        $plainData = file_get_contents($this->getFilePath($this->expectedDataFile));

        $genDiff = genDiff($this->getFilePath($this->jsonOne), $this->getFilePath($this->jsonTwo));

        self::assertEquals($plainData, $genDiff);
    }

    public function testGenDiffYAMLPlain()
    {
        $plainData = file_get_contents($this->getFilePath($this->expectedDataFile));

        $genDiff = genDiff($this->getFilePath($this->yamlOne), $this->getFilePath($this->yamlTwo));

        self::assertEquals($plainData, $genDiff);
    }

    public function testGenDiffJSONNested()
    {
        $nestedData = file_get_contents($this->getFilePath($this->expectedNestedDataFile));

        $genDiff = genDiff($this->getFilePath($this->nestedJsonOne), $this->getFilePath($this->nestedJsonTwo), "stylish");

        self::assertEquals($nestedData, $genDiff);
    }

    public function testGenDiffYAMLNested()
    {
        $nestedData = file_get_contents($this->getFilePath($this->expectedNestedDataFile));

        $genDiff = genDiff($this->getFilePath($this->nestedYamlOne), $this->getFilePath($this->nestedYamlTwo), "stylish");

        self::assertEquals($nestedData, $genDiff);
    }

    public function testGenDiffJSONNestedPlainFormat()
    {
        $nestedData = file_get_contents($this->getFilePath($this->expectedPlainFormatNestedDataFile));

        $genDiff = genDiff($this->getFilePath($this->nestedJsonOne), $this->getFilePath($this->nestedJsonTwo), "plain");

        self::assertEquals($nestedData, $genDiff);
    }

    public function testGenDiffYAMLNestedPlainFormat()
    {
        $nestedData = file_get_contents($this->getFilePath($this->expectedPlainFormatNestedDataFile));

        $genDiff = genDiff($this->getFilePath($this->nestedYamlOne), $this->getFilePath($this->nestedYamlTwo), "plain");

        self::assertEquals($nestedData, $genDiff);
    }
}