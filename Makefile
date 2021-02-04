install:
	composer install
lint:
	composer run-script phpcs -- --standard=PSR12 src gendiff
genDiffPlainDataJson:
	./gendiff ./tests/fixtures/fileJSON1.json ./tests/fixtures/fileJSON2.json
genDiffPlainDataYaml:
	./gendiff ./tests/fixtures/fileYAML1.yml ./tests/fixtures/fileYAML2.yml
genDiffNestedDataStylishFormatJson:
	./gendiff --format stylish ./tests/fixtures/fileNestedJSON1.json ./tests/fixtures/fileNestedJSON2.json
genDiffNestedDataStylishFormatYaml:
	./gendiff --format stylish ./tests/fixtures/fileNestedYAML1.yml ./tests/fixtures/fileNestedYAML2.yml
genDiffNestedDataPlainFormatJson:
	./gendiff --format plain ./tests/fixtures/fileNestedJSON1.json ./tests/fixtures/fileNestedJSON2.json
genDiffNestedDataPlainFormatYaml:
	./gendiff --format plain ./tests/fixtures/fileNestedYAML1.yml ./tests/fixtures/fileNestedYAML2.yml
genDiffNestedDataJsonFormatJson:
	./gendiff --format json ./tests/fixtures/fileNestedJSON1.json ./tests/fixtures/fileNestedJSON2.json
genDiffNestedDataJsonFormatYaml:
	./gendiff --format json ./tests/fixtures/fileNestedYAML1.yml ./tests/fixtures/fileNestedYAML2.yml
genDiffTests:
	./vendor/bin/phpunit tests