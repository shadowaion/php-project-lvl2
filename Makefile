install:
	composer install
lint:
	composer run-script phpcs -- --standard=PSR12 src bin
genDiffPlainDataJson:
	./bin/gendiff ./tests/fixtures/fileJSON1.json ./tests/fixtures/fileJSON2.json
genDiffPlainDataYaml:
	./bin/gendiff ./tests/fixtures/fileYAML1.yml ./tests/fixtures/fileYAML2.yml
genDiffNestedDataStylishFormatJson:
	./bin/gendiff --format stylish ./tests/fixtures/fileNestedJSON1.json ./tests/fixtures/fileNestedJSON2.json
genDiffNestedDataStylishFormatYaml:
	./bin/gendiff --format stylish ./tests/fixtures/fileNestedYAML1.yml ./tests/fixtures/fileNestedYAML2.yml
genDiffNestedDataPlainFormatJson:
	./bin/gendiff --format plain ./tests/fixtures/fileNestedJSON1.json ./tests/fixtures/fileNestedJSON2.json
genDiffNestedDataPlainFormatYaml:
	./bin/gendiff --format plain ./tests/fixtures/fileNestedYAML1.yml ./tests/fixtures/fileNestedYAML2.yml
genDiffNestedDataJsonFormatJson:
	./bin/gendiff --format json ./tests/fixtures/fileNestedJSON1.json ./tests/fixtures/fileNestedJSON2.json
genDiffNestedDataJsonFormatYaml:
	./bin/gendiff --format json ./tests/fixtures/fileNestedYAML1.yml ./tests/fixtures/fileNestedYAML2.yml
genDiffAll:
	./bin/gendiff ./tests/fixtures/fileJSON1.json ./tests/fixtures/fileJSON2.json
	./bin/gendiff ./tests/fixtures/fileYAML1.yml ./tests/fixtures/fileYAML2.yml
	./bin/gendiff --format stylish ./tests/fixtures/fileNestedJSON1.json ./tests/fixtures/fileNestedJSON2.json
	./bin/gendiff --format stylish ./tests/fixtures/fileNestedYAML1.yml ./tests/fixtures/fileNestedYAML2.yml
	./bin/gendiff --format plain ./tests/fixtures/fileNestedJSON1.json ./tests/fixtures/fileNestedJSON2.json
	./bin/gendiff --format plain ./tests/fixtures/fileNestedYAML1.yml ./tests/fixtures/fileNestedYAML2.yml
	./bin/gendiff --format json ./tests/fixtures/fileNestedJSON1.json ./tests/fixtures/fileNestedJSON2.json
	./bin/gendiff --format json ./tests/fixtures/fileNestedYAML1.yml ./tests/fixtures/fileNestedYAML2.yml
genDiffTests:
	./vendor/bin/phpunit tests