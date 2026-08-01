# COACHTECH お問合せフォームアプリ

ユーザーがお問い合わせ内容を入力し、確認画面を経由して送信できるお問い合わせフォームアプリです。
お問い合わせ情報はデータベースに保存され、管理機能およびAPIによる取得・登録・更新・削除機能を実装しています。

## 作成者

石川浩子

## 使用技術

PHP 8.5
Laravel 10.x
MySQL 8.4
Docker / Laravel Sail
Blade
Tailwind CSS
Vite
Laravel Fortify
Laravel Sanctum

## ER図

erDiagram

    users {
        bigint id PK
        string name
        string email
        string password
    }

    contacts {
        bigint id PK
        bigint category_id FK
        string first_name
        string last_name
        int gender
        string email
        string tel
        string address
        string building
        text detail
    }

    categories {
        bigint id PK
        string content
    }

    tags {
        bigint id PK
        string name
    }

    contact_tag {
        bigint contact_id FK
        bigint tag_id FK
    }


    categories ||--o{ contacts : "has many"

    contacts }o--|| categories : "belongs to"

    contacts ||--o{ contact_tag : "has many"

    tags ||--o{ contact_tag : "has many"

    users ||--o{ contacts : "has many"
    
## 開発環境URL

http://localhost

## 動作環境
Windows
WSL2
Docker Desktop
Laravel Sail
MySQL


## 環境構築手順

1. **リポジトリをクローン**

    ```bash
    git clone https://○○○○○○
    ```
プロジェクトディレクトリに移動
cd contact-form-app

2. **.envファイルの準備**


3. **Composer依存パッケージのインストール**

   ./vendor/bin/sail composer install

4. **Laravel Sailの起動**

    ./vendor/bin/sail up -d

5. **アプリケーションキーの生成**

   ./vendor/bin/sail artisan key:generate

6. **データベースのマイグレーションと初期データ投入**

 ./vendor/bin/sail artisan migrate --seed

8. **フロントエンドのビルド**
./vendor/bin/sail npm install
./vendor/bin/sail npm run build
./vendor/bin/sail npm run dev

10. **アプリケーションへのアクセス**

 　http://localhost
   
## テスト実行

  ./vendor/bin/sail test
  
## 機能一覧
お問い合わせフォーム入力
入力内容確認画面
お問い合わせ登録
バリデーション
カテゴリー管理
タグ管理
お問い合わせ一覧表示
お問い合わせ詳細表示
お問い合わせ更新
お問い合わせ削除
REST APIによるお問い合わせ操作
ページネーション
キーワード検索


## APIエンドポイント一覧

お問い合わせAPI

HTTP/ メソッド/ URI/ 概要
GET	/api/v1/contacts	お問い合わせ一覧取得（ページネーション付き）
GET	/api/v1/contacts/{contact}	お問い合わせ詳細取得
POST	/api/v1/contacts	お問い合わせ登録
PUT	/api/v1/contacts/{contact}	お問い合わせ更新
DELETE	/api/v1/contacts/{contact}	お問い合わせ削除


