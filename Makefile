install:
	composer install
lint:
	composer run-script phpcs -- --standard=PSR12 src gendiff
genDiffPlainJson:
	./gendiff ./tests/fixtures/fileJSON1.json ./tests/fixtures/fileJSON2.json
genDiffPlainYaml:
	./gendiff ./tests/fixtures/fileYAML1.yml ./tests/fixtures/fileYAML2.yml
genDiffNestedJson:
	./gendiff ./tests/fixtures/fileNestedJSON1.json ./tests/fixtures/fileNestedJSON2.json
genDiffNestedYaml:
	./gendiff ./tests/fixtures/fileNestedYAML1.yml ./tests/fixtures/fileNestedYAML2.yml
genDiffTests:
	./vendor/bin/phpunit tests