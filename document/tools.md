# ツール関連

前提として全て Docker 環境で Make を使用しています

## 😼 GitHub Actions

GitHub が用意している CIツール
publicリポジトリ なら無料 privateリポジトリ であれば月でCIに掛かる時間 `2000時間` まで無料

以下のツールを実行する
- Larastan
- PHP-CS-Fixer
- PHPUnit

## 🐘 PHPStan(Larastan)

https://github.com/nunomaduro/larastan

PHPの静的解析ツール
PHPDoc や変数の未定義/分岐チェックなどをコードを実行せずに解析する
今回は PHPStan のラッパーライブラリの Larastan を使用する

### 使用方法

#### Docker環境

```
make analyze
```

#### Doker環境ではない時

```
./vendor/bin/phpstan analyze --memory-limit=2G
```

### 設定方法

プロジェクト配下の `.phpstan.neon` で設定が可能
yaml形式での記述

- paths に対象ディレクトリを指定
- level で解析のレベルを指定
    - 1 ~ 7(max) までがある
- ルールは [こちら](https://phpstan.org/config-reference) を参照

```yaml=
includes:
    - ./vendor/nunomaduro/larastan/extension.neon
parameters:
    paths:
        - app/
        - database/
        - tests/
    level: max
    excludePaths:
        - ./*/*/FileToBeExcluded.php
    checkMissingIterableValueType: false
```

## 🦅 PHP-CS-Fixer

https://github.com/FriendsOfPHP/PHP-CS-Fixer

指定したコーディング規約に自動で変換してくれるツール
GitHub Actions に組み込むことで push した際に自動で整形してくれる

### 使用方法

#### Docker環境

- 自動整形対象の差分

```
make cs-dry-run
```

- 自動整形対象のfix

```
make cs-fix
```

#### Docker環境ではない時

- 自動整形対象の差分

```
./vendor/bin/php-cs-fixer fix -v --diff --dry-run
```

- 自動整形対象のfix

```
./vendor/bin/php-cs-fixer fix -v --diff
```

## 設定方法

プロジェクト配下の `.php-cs-fixer.dist.php` で設定が可能

- PhpCsFixer\Finder::create()->in([]) で適用するディレクトリを指定
- setRules([]) で適用するルールを指定
    - ルールは [こちら](https://mlocati.github.io/php-cs-fixer-configurator/#version:3.0) を参照

```php=
<?php declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database/factories',
        __DIR__ . '/database/seeders',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ]);

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PhpCsFixer:risky' => true,
        'blank_line_after_opening_tag' => false,
        'linebreak_after_opening_tag' => false,
        'declare_strict_types' => true,
        'phpdoc_types_order' => [
            'null_adjustment' => 'always_last',
            'sort_algorithm' => 'none',
        ],
        'no_superfluous_phpdoc_tags' => false,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'php_unit_test_case_static_method_calls' => [
            'call_type' => 'this'
        ],
        'phpdoc_align' => [
            'align' => 'left',
        ],
        'not_operator_with_successor_space' => true,
    ])
    ->setFinder($finder);

```
