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

## Hướng dẫn thêm tài khoản Admin / Đại lý tổng / Đại lý con

Hệ thống chưa có giao diện "tạo tài khoản" cho 3 loại này — phải thêm trực tiếp vào database bằng SQL. Cách xác thực thực tế nằm trong `core/Controller.php`, `AdminController.php`, `AgentController.php`:

| Loại tài khoản | Bảng lưu | Cột phân quyền | Đăng nhập tại | Mật khẩu |
|---|---|---|---|---|
| Admin (quản trị web) | `CsmLogins` | — | `/admin/login` | Plain text |
| Đại lý tổng (Super Agent) | `LoginTables` | `ActiveRoleID = 3` | `/dai-ly/login` | Plain text |
| Đại lý con (Agent) | `LoginTables` | `ActiveRoleID = 1` | `/dai-ly/login` | Plain text |
| User thường | `LoginTables` | `ActiveRoleID = NULL/0` | `/user/login` | MD5 viết hoa |

`AdminController::loginAjax` và `AgentController::loginAjax` so sánh mật khẩu trực tiếp (`$row['Password'] !== $password`), không hash. Vì vậy khi insert SQL cho Admin/Đại lý, nhập mật khẩu ở dạng văn bản thường — không md5. Riêng User thường được `AuthController` hash bằng `strtoupper(md5($password))`.

### 1. Thêm tài khoản Admin

```sql
INSERT INTO CsmLogins (LoginName, Password, Premission, RegTime)
VALUES (N'admin01', N'MatKhauCuaBan', 1, GETDATE());
```

Đăng nhập tại `/admin/login`.

### 2. Thêm tài khoản Đại lý tổng

```sql
INSERT INTO LoginTables (LoginName, Password, Phone, Status, Date, ActiveRoleID, ActiveRoleName)
VALUES (N'daily_tong01', N'MatKhauCuaBan', N'0900000000', 1, GETDATE(), 3, N'Đại lý tổng');

-- Cấp KNB ban đầu để phân phối xuống đại lý con
INSERT INTO KTCoins (UserID, UserName, KCoin, UpdateTime)
VALUES ((SELECT ID FROM LoginTables WHERE LoginName = N'daily_tong01'), N'daily_tong01', 1000000, GETDATE());
```

Đăng nhập tại `/dai-ly/login`, sẽ thấy thêm menu **Đại lý** (`/dai-ly/agents`) để nạp KNB cho đại lý con.

### 3. Thêm tài khoản Đại lý con

```sql
INSERT INTO LoginTables (LoginName, Password, Phone, Status, Date, ActiveRoleID, ActiveRoleName)
VALUES (N'daily_con01', N'MatKhauCuaBan', N'0900000001', 1, GETDATE(), 1, N'Đại lý');
```

Đăng nhập cùng `/dai-ly/login`, chỉ thấy trang quản lý người chơi do mình nạp (`/dai-ly/users`), không có menu "Đại lý".

### 4. Nâng cấp tài khoản user thường thành đại lý

```sql
UPDATE LoginTables
SET ActiveRoleID = 1, ActiveRoleName = N'Đại lý'   -- đổi 1 thành 3 nếu muốn lên đại lý tổng
WHERE LoginName = N'ten_tai_khoan';
```

Tài khoản user thường có `Password` lưu dạng MD5 viết hoa, nhưng trang đại lý so sánh plain text — sau khi nâng cấp **phải đặt lại mật khẩu plain text** mới đăng nhập được ở `/dai-ly/login`:

```sql
UPDATE LoginTables SET Password = N'MatKhauMoi' WHERE LoginName = N'ten_tai_khoan';
```

### 5. Kiểm tra nhanh

```sql
-- Toàn bộ đại lý (tổng + con)
SELECT LoginName, ActiveRoleID, ActiveRoleName, Phone FROM LoginTables WHERE ActiveRoleID IN (1, 3);

-- Toàn bộ admin
SELECT LoginName, Premission FROM CsmLogins;
```

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
