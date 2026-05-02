# coachtechフリマ

## 環境構築

### Dockerビルド
* `git clone <リポジトリのURL>`
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
<!-- 画像をアップロードしたらここにパスを記述 -->
![ER図](storage/app/public/er_diagram.png)

## 作成者
* 黛 紗由吉 (Mayuzumi Sayukichi)
* COACHTECH受講生 (2026年6月卒業予定)
EOF
