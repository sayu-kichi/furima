# coachtechフリマ

## 環境構築

### Dockerビルド
* `git clone <https://github.com/sayu-kichi/furima.git>`
* `docker-compose up -d --build`

### Laravel環境構築
* `docker-compose exec php bash`
* `composer install`
* `cp .env.example .env`
* `php artisan key:generate`
* `php artisan migrate`
* `php artisan db:seed`

## 開発環境
* 商品一覧画面（トップ）：http://localhost/
* 会員登録画面：http://localhost/register
* ログイン画面：http://localhost/login
* メール認証誘導画面：http://localhost/email/verify
* プロフィール設定画面（認証後）：http://localhost/mypage/profile
* マイページ：http://localhost/mypage
* phpMyAdmin：http://localhost:8080/

## 使用技術(実行環境)
* PHP 8.x
* Laravel 9.x / 10.x
* MySQL 8.0.x
* Nginx 1.21.x
* Docker / Docker Compose
* Stripe (決済機能)

## ER図
src/storage/app/public/フリマアプリ.drawio (1).png

## 作成者
* masunaga sayuki
EOF
