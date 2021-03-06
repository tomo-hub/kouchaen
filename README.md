# オリジナルECサイト


## 簡単な説明
アプリケーションのコンセプトは、「幅広い年齢の女性をターゲットに、様々な紅茶の種類から自分の好みの紅茶が購入できるオンラインショップサイト」を目指しました。
言語としてはPHPを使用し、依存関係をわかりやすくするためにMVCモデルで制作しました。
開発環境は、dockerコンテナを用いて構築しました。機能面では、商品一覧ページの検索機能と並び替え機能の連携を工夫しました。


### デモ

* [こうちゃ園](http://118.27.14.177)

### ログイン

* id: sampleuser 
* pass: password 

## 機能

### 基本機能

* サインアップ・ログイン
* 商品管理
* カート機能
* キーワード検索
* カテゴリ検索
* 並び替え機能
* ページネーション

### セキュリティ

* SQLインジェクション対策
* XSS対策
* CSRF対策
* パスワードハッシュ化
## 実行環境

### conoha VPS (LAMP)

* centos7.7
* apache
* mariaDB
* php

## 使用言語/開発環境

### Dockerコンテナ

* php7.2-apache
* mysql5.7
* phpmyadmin

### その他

* ワイヤーフレーム: figma
* バージョン管理：  git-github

## 作者/ライセンス

* Tomoko Wada
