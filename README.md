# JX1 Hồi Ức Mobile — Game Portal

Website portal cho game JX1 Hồi Ức Mobile, bao gồm trang chủ tin tức, hệ thống tài khoản người chơi, thanh toán, và trang admin quản lý nội dung.

---

## Công nghệ

- **Backend:** PHP 8.1, kiến trúc MVC tự xây (không dùng framework)
- **Frontend:** Custom CSS + Bootstrap 4 (admin), Swiper.js 6.5.8, jQuery
- **Database:** MySQL 8.0, PDO — 2 database riêng biệt:
  - `gcpos` — portal game (tài khoản, thanh toán, máy chủ)
  - `homejx` — blog/tin tức (bài viết, slide, SEO, hoạt động ngày)
- **Runtime:** Docker / docker-compose (ARM64 / Apple Silicon)
- **Editor nội dung:** TinyMCE 8

---

## Cấu trúc thư mục

```
jx1-game/
├── app/
│   ├── Controllers/        # AdminController, PostController, HomeController, ...
│   ├── Models/             # Post, User, Payment, SiteConfig
│   └── Views/
│       ├── layouts/        # main.php, post.php, category.php, admin.php, ...
│       ├── home/           # index.php
│       ├── post/           # view.php, category.php
│       └── admin/          # dashboard, add/edit post, seo, slide, hoatdong
├── core/
│   ├── Router.php          # HTTP router (GET/POST/HEAD)
│   ├── Controller.php      # Base controller, view(), authAdmin()
│   └── Model.php           # Base model
├── config/
│   ├── app.php             # APP_URL, APP_NAME, timezone
│   └── database.php        # db_portal(), db_blog()
├── includes/
│   └── helpers.php
├── public/
│   ├── index.php           # Entry point, định nghĩa tất cả routes
│   ├── .htaccess           # Rewrite tất cả request về index.php
│   └── assets/             # CSS, JS, ảnh
├── docker/
│   ├── homejx-full.sql     # SQL dump database homejx
│   └── *.sql               # Các file init khác
├── docker-compose.yml
└── Dockerfile
```

---

## Cài đặt & chạy

### Yêu cầu
- Docker Desktop (Apple Silicon / AMD64)

### Khởi động

```bash
docker-compose up -d
```

Truy cập: [http://localhost:8090](http://localhost:8090)

### Dừng

```bash
docker-compose down
```

---

## Routes chính

| Method | URL | Chức năng |
|--------|-----|-----------|
| GET | `/` | Trang chủ |
| GET | `/tin-tuc` `/su-kien` `/tinh-nang` `/cam-nang` | Danh mục bài viết |
| GET | `/{slug}.html` | Chi tiết bài viết |
| GET | `/user/login` | Đăng nhập người chơi |
| GET | `/user` | Portal tài khoản |
| GET | `/admin` | Dashboard admin blog |
| GET | `/admin/posts` | Quản lý bài viết |
| GET | `/admin/seo` | Cài đặt SEO |
| GET | `/admin/slide` | Quản lý slide |
| GET | `/admin/hoatdong` | Hoạt động hằng ngày |
| GET | `/game-admin` | Dashboard admin game |

---

## Admin

- **Blog admin:** `/admin/login`
- **Game admin:** `/game-admin/login`
- Session key: `$_SESSION['blog_admin']`

---

## Database

Hai kết nối PDO được khởi tạo qua helper function trong `config/database.php`:

```php
db_portal();  // database gcpos
db_blog();    // database homejx
```

---

## Layouts

| Layout | Dùng cho |
|--------|----------|
| `main.php` | Trang chủ |
| `post.php` | Chi tiết bài viết |
| `category.php` | Danh mục bài viết |
| `admin.php` | Tất cả trang admin |
| `user.php` | Portal người chơi |
