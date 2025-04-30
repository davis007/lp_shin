<?php

return [

    /*
    |--------------------------------------------------------------------------
    | バリデーション言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行はバリデータクラスにより使用されるデフォルトのエラー
    | メッセージです。サイズルールのようにいくつかのバリデーションを
    | 持っているものもあります。メッセージはご自由に調整してください。
    |
    */

    'accepted' => ':attributeを承認してください。',
    'accepted_if' => ':otherが:valueの場合、:attributeを承認してください。',
    'active_url' => ':attributeが有効なURLではありません。',
    'after' => ':attributeには、:dateより後の日付を指定してください。',
    'after_or_equal' => ':attributeには、:date以降の日付を指定してください。',
    'alpha' => ':attributeはアルファベットのみがご利用できます。',
    'alpha_dash' => ':attributeはアルファベットとダッシュ(-)及び下線(_)がご利用できます。',
    'alpha_num' => ':attributeはアルファベット数字がご利用できます。',
    'array' => ':attributeは配列でなくてはなりません。',
    'ascii' => ':attributeは半角英数字と記号のみ含めてください。',
    'before' => ':attributeには、:dateより前の日付をご利用ください。',
    'before_or_equal' => ':attributeには、:date以前の日付をご利用ください。',
    'between' => [
        'array' => ':attributeは、:min個から:max個の間で指定してください。',
        'file' => ':attributeは、:min kBから、:max kBの間で指定してください。',
        'numeric' => ':attributeは、:minから:maxの間で指定してください。',
        'string' => ':attributeは、:min文字から:max文字の間で指定してください。',
    ],
    'boolean' => ':attributeは、trueかfalseを指定してください。',
    'can' => ':attributeには権限のない値が含まれています。',
    'confirmed' => ':attributeと確認フィールドが一致していません。',
    'contains' => ':attributeには必須の値が含まれていません。',
    'current_password' => 'パスワードが正しくありません。',
    'date' => ':attributeには有効な日付を指定してください。',
    'date_equals' => ':attributeには、:dateと同じ日付けを指定してください。',
    'date_format' => ':attributeは:format形式で指定してください。',
    'decimal' => ':attributeは:decimal桁の小数点を含む必要があります。',
    'declined' => ':attributeは拒否する必要があります。',
    'declined_if' => ':otherが:valueの場合、:attributeを拒否する必要があります。',
    'different' => ':attributeと:otherには、異なった内容を指定してください。',
    'digits' => ':attributeは:digits桁で指定してください。',
    'digits_between' => ':attributeは:min桁から:max桁の間で指定してください。',
    'dimensions' => ':attributeの図形サイズが正しくありません。',
    'distinct' => ':attributeには異なった値を指定してください。',
    'doesnt_end_with' => ':attributeは次のいずれかで終わってはいけません: :values。',
    'doesnt_start_with' => ':attributeは次のいずれかで始まってはいけません: :values。',
    'email' => ':attributeには、有効なメールアドレスを指定してください。',
    'ends_with' => ':attributeには、:valuesのどれかで終わる値を指定してください。',
    'enum' => '選択された:attributeは無効です。',
    'exists' => '選択された:attributeは正しくありません。',
    'extensions' => ':attributeには、次のいずれかの拡張子を含める必要があります: :values。',
    'file' => ':attributeにはファイルを指定してください。',
    'filled' => ':attributeに値を指定してください。',
    'gt' => [
        'array' => ':attributeには、:value個より多くのアイテムを指定してください。',
        'file' => ':attributeには、:value kBより大きなファイルを指定してください。',
        'numeric' => ':attributeには、:valueより大きな値を指定してください。',
        'string' => ':attributeは、:value文字より長く指定してください。',
    ],
    'gte' => [
        'array' => ':attributeには、:value個以上のアイテムを指定してください。',
        'file' => ':attributeには、:value kB以上のファイルを指定してください。',
        'numeric' => ':attributeには、:value以上の値を指定してください。',
        'string' => ':attributeは、:value文字以上で指定してください。',
    ],
    'hex_color' => ':attributeは有効な16進数カラーコードである必要があります。',
    'image' => ':attributeには画像ファイルを指定してください。',
    'in' => '選択された:attributeは正しくありません。',
    'in_array' => ':attributeには:otherの値を指定してください。',
    'integer' => ':attributeは整数で指定してください。',
    'ip' => ':attributeには、有効なIPアドレスを指定してください。',
    'ipv4' => ':attributeには、有効なIPv4アドレスを指定してください。',
    'ipv6' => ':attributeには、有効なIPv6アドレスを指定してください。',
    'json' => ':attributeには、有効なJSON文字列を指定してください。',
    'list' => ':attributeはリストでなければなりません。',
    'lowercase' => ':attributeは小文字のみで指定してください。',
    'lt' => [
        'array' => ':attributeには、:value個より少ないアイテムを指定してください。',
        'file' => ':attributeには、:value kBより小さなファイルを指定してください。',
        'numeric' => ':attributeには、:valueより小さな値を指定してください。',
        'string' => ':attributeは、:value文字より短く指定してください。',
    ],
    'lte' => [
        'array' => ':attributeには、:value個以下のアイテムを指定してください。',
        'file' => ':attributeには、:value kB以下のファイルを指定してください。',
        'numeric' => ':attributeには、:value以下の値を指定してください。',
        'string' => ':attributeは、:value文字以下で指定してください。',
    ],
    'mac_address' => ':attributeは有効なMACアドレスである必要があります。',
    'max' => [
        'array' => ':attributeは:max個以下指定してください。',
        'file' => ':attributeには、:max kB以下のファイルを指定してください。',
        'numeric' => ':attributeには、:max以下の数字を指定してください。',
        'string' => ':attributeは、:max文字以下で指定してください。',
    ],
    'max_digits' => ':attributeは:max桁以下で指定してください。',
    'mimes' => ':attributeには:valuesタイプのファイルを指定してください。',
    'mimetypes' => ':attributeには:valuesタイプのファイルを指定してください。',
    'min' => [
        'array' => ':attributeは:min個以上指定してください。',
        'file' => ':attributeには、:min kB以上のファイルを指定してください。',
        'numeric' => ':attributeには、:min以上の数字を指定してください。',
        'string' => ':attributeは、:min文字以上で指定してください。',
    ],
    'min_digits' => ':attributeは:min桁以上で指定してください。',
    'missing' => ':attribute フィールドは存在してはなりません。',
    'missing_if' => ':otherが:valueの場合、:attributeフィールドは存在してはなりません。',
    'missing_unless' => ':otherが:valueでない限り、:attributeフィールドは存在してはなりません。',
    'missing_with' => ':valuesが存在する場合、:attributeフィールドは存在してはなりません。',
    'missing_with_all' => ':valuesが存在する場合、:attributeフィールドは存在してはなりません。',
    'multiple_of' => ':attributeには、:valueの倍数を指定してください。',
    'not_in' => '選択された:attributeは正しくありません。',
    'not_regex' => ':attributeの形式が正しくありません。',
    'numeric' => ':attributeには、数字を指定してください。',
    'password' => [
        'letters' => ':attributeは少なくとも1つの文字を含める必要があります。',
        'mixed' => ':attributeは少なくとも大文字と小文字を1つずつ含める必要があります。',
        'numbers' => ':attributeは少なくとも1つの数字を含める必要があります。',
        'symbols' => ':attributeは少なくとも1つの記号を含める必要があります。',
        'uncompromised' => '指定された:attributeは、データ漏洩に現れています。別の:attributeを選択してください。',
    ],
    'present' => ':attributeが存在していません。',
    'present_if' => ':otherが:valueの場合、:attributeフィールドが存在する必要があります。',
    'present_unless' => ':otherが:valueでない限り、:attributeフィールドが存在する必要があります。',
    'present_with' => ':valuesが存在する場合、:attributeフィールドも存在する必要があります。',
    'present_with_all' => ':valuesがすべて存在する場合、:attributeフィールドも存在する必要があります。',
    'prohibited' => ':attributeフィールドは禁止されています。',
    'prohibited_if' => ':otherが:valueの場合、:attributeフィールドは禁止されています。',
    'prohibited_unless' => ':otherが:valuesにない限り、:attributeフィールドは禁止されています。',
    'prohibits' => ':attributeフィールドは:otherが存在することを禁止しています。',
    'regex' => ':attributeに正しい形式を指定してください。',
    'required' => ':attributeは必ず指定してください。',
    'required_array_keys' => ':attributeフィールドには、:valuesのエントリを含める必要があります。',
    'required_if' => ':otherが:valueの場合、:attributeも指定してください。',
    'required_if_accepted' => ':otherが承認された場合、:attributeも指定してください。',
    'required_if_declined' => ':otherが拒否された場合、:attributeも指定してください。',
    'required_unless' => ':otherが:valuesでない場合、:attributeを指定してください。',
    'required_with' => ':valuesを指定する場合は、:attributeも指定してください。',
    'required_with_all' => ':valuesを指定する場合は、:attributeも指定してください。',
    'required_without' => ':valuesを指定しない場合は、:attributeを指定してください。',
    'required_without_all' => ':valuesのどれも指定しない場合は、:attributeを指定してください。',
    'same' => ':attributeと:otherには同じ値を指定してください。',
    'size' => [
        'array' => ':attributeは:size個指定してください。',
        'file' => ':attributeのファイルは、:sizeキロバイトでなくてはなりません。',
        'numeric' => ':attributeは:sizeを指定してください。',
        'string' => ':attributeは:size文字で指定してください。',
    ],
    'starts_with' => ':attributeには、:valuesのどれかで始まる値を指定してください。',
    'string' => ':attributeは文字列を指定してください。',
    'timezone' => ':attributeには、有効なゾーンを指定してください。',
    'unique' => ':attributeの値は既に存在しています。',
    'uploaded' => ':attributeのアップロードに失敗しました。',
    'uppercase' => ':attributeは大文字のみで指定してください。',
    'url' => ':attributeに正しい形式を指定してください。',
    'ulid' => ':attributeは有効なULIDである必要があります。',
    'uuid' => ':attributeに有効なUUIDを指定してください。',

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション言語行
    |--------------------------------------------------------------------------
    |
    | "属性.ルール"の規約でキーを指定することでカスタムバリデーション
    | メッセージを定義できます。指定した属性ルールに対する特定の
    | カスタム言語行を手早く指定できます。
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | カスタムバリデーション属性名
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は、例えば"email"の代わりに「メールアドレス」のように、
    | 読み手にフレンドリーな表現でプレースホルダーを置き換えるために指定する
    | 言語行です。これはメッセージをよりきれいに表示するために役に立ちます。
    |
    */

    'attributes' => [
        'name' => '名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
    ],

];
