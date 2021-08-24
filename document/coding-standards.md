# コーディングルール

`PSR-12` に準拠

## PHP コーディングルール

### そもそものお約束

- 無駄な改行は入れない🙅‍♂️
- 無駄な空白も入れない🙅‍♂️
- 不必要なコメントアウトは必ず消す🙅‍♂️
- `==` などによる比較はダメ🙅‍♂️型まで判定する完全一致を使用しましょう `===`

### declareモード

対象ファイルの型チェックが厳密になります `必ず使ってください！！`

```php=
<?php

declare(strict_types=1);
```

### use

- 改行を開けずにアルファベット順

```php=
use App\Models\User;
use Illuminate\Http\Request;
```

### 変数宣言

- イコールにはスペースを入れる（というか記号の横にはほぼ全部スペース）

```php=
$sample = 'sample';
```

### 配列

- 配列は `array()` ではなく `[]` を使用する
- ダブルアローにスペースを入れる

```php=
$samples = [
    'tokyo' => 1,
    'osaka' => 2,
];
```

### メソッドチェーン

- メソッドチェーンにはスペースを入れない
- 複数メソッドチェーンを使用する時は、一つインデントを下げて折り返す

```php=
$this->userModel
    ->where('id', $id)
    ->get();
```

### if文

- 記述方法は以下の通りスペースを空ける
- else は極力使わない様に心掛けて実装する（もちろん必要な場合は使ってOK）
    - elseの中身が大きくなればなるほどしんどくなる
- ネストした if文 は極力使用しない（最大でも2回まで）
    - これまた条件が増えた時に有名な波動拳の画像みたいになる
- 早期リターンなどを駆使して無駄な分岐を省く
- `!` は早期リターンや簡単な条件式以外では使用しない

```php=
if ($sample) {
    
}
```

> 以下、早期リターンの例

🙅‍♂️ ダメな例

```php=
if ($id) {
    $this->find($id);
} else {
    return null;
}
```

🙆‍♂️ ナイスな例

```php=
if (!id) {
    return null;
}

$this->find($id);
```

### 型宣言

- 引数と戻り値には必ず型を書く
- 引数と戻り値のプリミティブ型（string int bool...etc）は小文字
- null許容する場合は型の前に `?` を用いる

```php=
public function sample(?int $id, string $name): ?string
{
    if (!$id) {
        return;
    }
    
    return `{$id} のユーザーは {$name} です`;
}
```

### 例外処理

- 例外が起きそうな箇所は必ず例外処理を入れる

```php=
if ($isFollow) {
    throw new Exception('すでにフォロー済みです。');
}
```

### PHPDoc

ただのコメントじゃないよ（静的解析で使用します）
それぞれに改行を入れよう

- @param が引数
- @return が戻り値
- @throws が例外処理

```php=
/**
 * sampleの実装
 *
 * @param int|null $id
 * @param string $name
 *
 * @return string|null
 *
 * @throws Exception
 */
public function sample(?int $id, string $name): ?string
{
    // 省略
    
    if ($isFollow) {
        throw new Exception('すでにフォロー済みです。');
    }
    
    // 省略
}
```

## Laravel コーディングルール

### 構成

- Controller
  - Controller は `単数形` + `Controller`
      - `例: SampleController`
  - バリデーション処理は書かないこと
  
- Model
  - 基本的には以下の責務以外は書かない
      - プロパティ（定数含む）
      - リレーション
      - DB操作（Eloquent） 
  - ビジネスロジックは Serviceクラス に責務を寄せます

- View
  - Controller名 に対して単数形でディレクトリを切ること
      - `例: views/sample/index.blade.php`
  - URL を使用する際は必ず `route()` を使うこと
  - View からメソッドを呼び出さないこと
  - なるべく if文 などの使用を避けて Controller などでうまいことできないか考える（もちろん必要な場合は使ってもOK）
  - コンポーネント化できそうなところは ViewComponent を使用する

- Request
  - バリデーション処理を書くこと
  - それ以外でも Controller の前処理を書いてもいい

- Service
  - ビジネスロジックはここに書く（複雑な処理やリレーション間の保存を制御など）

- ViewComposer
  - 全体で共通として使用したい変数をここで定義する
  - 使用する際は必ず `app/Http/ViewComposers` 配下にクラスを定義してから `ViewComposerProvider` で使うようにすること
  - layoutsなど `Controller` が存在しないファイルに対して以外極力使わないようにする
  - View で使用する際はコメント必須（どこから呼び出せれているか分からなくなるので）

- ViewComponent
  - コンポーネント化（部品化）できそうな箇所はこちらに切り出す 
  - `Conroller` から `View(blade)` に渡した値を加工したい時に使用する

- web（ルーティング）
  - なるべく `group()` でまとめる
  - メソッドチェーンで書く
  - `name()` を必ず使用する

### メソッド・コンストラクタインジェクション

- new は基本的に使用せずにメソッドインジェクションを使用する
- クラス内で2つ以上同じメソッドインジェクションをしている場合はコンストラクトに移行すること

> 以下、メソッドインジェクションを2つ以上使用している時の例

🙅‍♂️ ダメな例

```php=
public function index(User $userModel) {
  return $userModel;
}

public function show(User $userModel) {
  return $userModel;
}
```

🙆‍♂️ ナイスな例

```php=
private $userModel;

public function __construct(User $userModel) {
  $this->userModel = $userModel;
}

public function index() {
  return $this->userModel;
}

public function show() {
  return $this->userModel;
}
```

### トランザクション

- 保存や削除が保証されて欲しい箇所や複数を跨ぐ保存処理などはトランザクションを貼る

```php=
return DB::transaction(function () use ($userId) {
    return $this->create([
        'user_id' => $userId,
    ]);
});
```

### View へ変数を渡す

- `compact` は使わない様にする
    - 変数宣言が必須になるのと連想配列の様にキー名を指定できないことで弊害が起きる
- 連想配列を使おう

🙅‍♂️ ダメな例

```php=
$items = $item->get();
$categories = $category->get();

return view('sample', compact('items', 'categories'));
```

🙆‍♂️ ナイスな例

```php=
return view('sample', [
    'items' => $item->get(),
    'categories' => $category->get()
]);
```

### マイグレーションの書き方

- 親テーブル > 小テーブル > 中間テーブル の順で作成すること
- `$table->id` や `$table->timestamps()` など以外は comment()を書く
- 外部キーは `id` の次に書く
    - 外部キーは `$table->foreignId('user_id')->constrained()` の様に書く
- created_at や deleted_at などの timestamp は下の方に書く

> 例

```php=
public function up()
{
    Schema::create('user_information', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained();
        $table->string('muttering')->nullable()->comment('一言コメント');
        $table->string('icon')->nullable()->comment('プロフィールアイコン');
        $table->timestamps();
    });
}
```

### 定数の扱い

- Model（テーブル）と紐づくデータは `app/Models/` 配下のModelに書く
- グローバルで扱いたいデータは `app/Const/` に書く

> 例

`Modelに書くパターン`

```php=
class User extends Model
{
    private const CLASSIFICATION = [
        1 => '一般',
        2 => '学生'
    ];
}
```

`app/Const/GlobalConst`

```php=
namespace App\Consts;

class GlobalConst
{
    public const PREEFECTURE = [
        '北海道',
        '青森',
        // 省略
    ]
}
```
