# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Khởi động

Chạy trên XAMPP với VirtualHost trỏ document root vào `public/`.
Database import thủ công từ phpMyAdmin.

## Kiến trúc

PHP 8.1 MVC tự xây, không dùng framework. Entry point duy nhất: `public/index.php`.

- **Router** (`core/Router.php`): match GET/POST/HEAD bằng regex, dispatch tới `Controller::method`. Params từ `{slug}` trong path được truyền thẳng làm argument.
- **Controller** (`core/Controller.php`): base class — `view()`, `json()`, `redirect()`, `authAdmin()`, `authUser()`, `authGameAdmin()`
- **Model** (`core/Model.php`): base class abstract — `query()`, `queryOne()`, `execute()` — đều dùng PDO prepared statements
- **Autoload**: `spl_autoload_register` tìm trong `app/Controllers/` và `app/Models/`
- **Helper**: `url_slug()` trong `includes/helpers.php` — chuyển tiếng Việt sang slug Latin

## Database

**Microsoft SQL Server** — kết nối qua `sqlsrv` PDO driver (cần `php_pdo_sqlsrv.dll` trong XAMPP).  
Cấu hình trong `.env`. `db_portal()` và `db_blog()` đều trỏ vào cùng một database `kiemthedb`.

### Schema `kiemthedb`

| Bảng | Mục đích | Cột chính |
|------|----------|-----------|
| `LoginTables` | Tài khoản người chơi | ID, LoginName, Password, Phone, Status, ActiveRoleID, ActiveRoleName, KCoin, Commission |
| `KTCoins` | Ví xu người chơi | ID, UserID, UserName, KCoin, UpdateTime |
| `ServerLists` | Danh sách máy chủ | ID, strServerName, nServerID, nServerPort, nStatus, strURL, nOnlineNum |
| `ServerListsIos` | Máy chủ iOS | (cùng cấu trúc ServerLists) |
| `GiftCodes` | Gift code | ID, Code, Status, ItemList, CodeType, MaxActive, ServerID |
| `GiftCodeLogs` | Log dùng gift code | ID, Code, ActiveRole, ActiveTime, ServerID |
| `RechageLogs` | Log nạp xu | ID, UserID, UserName, CoinValue, BeforeCoin, AfterCoin, RechaheType, TransID, Status |
| `history_gamebank` | Lịch sử nạp thẻ | historyid, cardserial, cardpin, cardtype, price, coins, status, UserID, tran_id |
| `LogsTrans` | Log giao dịch xu | ID, UserID, RoleID, RoleName, ServerID, Value, BeforeValue, AfterValue |
| `lichcmnsu` | Lịch sử chuyển NSU | id, nguoichuyen, nguoinhan, sodongchuyen, thoigian |
| `NewsTables` | Tin tức/bài viết | ID, Cataogory, Title, Context, DateTime |
| `ChatDatas` | Log chat | ID, FromRoleName, ToRoleName, Channel, ChatTime |
| `Configs` | Cấu hình event | ID, StartKM, EndKM, NormalRate, KMRate |
| `quantri` | Quản trị viên blog | id, taikhoan, chucvu |
| `CsmLogins` | CSM/GM login | ID, LoginName, Password, Premission |
| `TokenManagers` | Token xác thực | id, username, tokencreate, time, requestSendStatus |

## Thêm route mới

Khai báo trong `public/index.php`:
```php
$router->get('/duong-dan', [Controller::class, 'method']);
$router->post('/duong-dan', [Controller::class, 'method']);
```

Tất cả AJAX POST dùng pattern `/[section]/ajax/[action]` và trả về `$this->json([...])`.

## Layouts

Mỗi trang dùng một layout riêng, truyền qua `$this->view()`:

| Layout | File |
|--------|------|
| Trang chủ | `app/Views/layouts/main.php` |
| Chi tiết bài | `app/Views/layouts/post.php` |
| Danh mục | `app/Views/layouts/category.php` |
| Admin blog | `app/Views/layouts/admin.php` |
| Admin game | `app/Views/layouts/game-admin.php` |
| Người chơi | `app/Views/layouts/user.php` |

Layout include `$content_view` — tên view tương đối từ `app/Views/`.

## Ba hệ thống auth

| Đối tượng | Session key | Guard method | Password |
|-----------|-------------|--------------|----------|
| Blog admin | `$_SESSION['blog_admin']` | `authAdmin()` | `password_verify()` (bcrypt) |
| Game admin | `$_SESSION['useradmin']` + `$_SESSION['admin'] === '2205'` | `authGameAdmin()` | `strtoupper(md5())` |
| Người chơi | `$_SESSION['username']` | `authUser()` | `strtoupper(md5())` |

```php
$this->authAdmin();      // redirect /admin/login
$this->authGameAdmin();  // redirect /game-admin/login
$this->authUser();       // redirect /user/login
```

Mật khẩu game/người chơi lưu trong cả `LoginTables.Password` và `gc_user.pass`, cần cập nhật cả hai khi đổi mật khẩu (`User::updatePassword()` + `User::updatePortalPassword()`).

## PostController

- Method hiển thị bài: `show(string $slug)` — không đặt tên method là `view` (trùng tên base class)
- Category slug lấy từ `parse_url($_SERVER['REQUEST_URI'])`, không qua route param (tất cả category dùng chung 1 route handler)
- Related posts dùng `GROUP BY p.postID` thay vì `SELECT DISTINCT` (tránh lỗi MySQL 3065)

## HomeController — Category IDs cứng

```php
$news     = $post->getByCategory(5, 20);  // Tin tức
$events   = $post->getByCategory(4, 20);  // Sự kiện
$guides   = $post->getByCategory(1, 20);  // Cẩm nang
$features = $post->getByCategory(2, 20);  // Tính năng
```

## Excerpt bài viết

```php
mb_substr(strip_tags(html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8')), 0, 200)
```

Luôn decode HTML entities trước khi strip_tags để tránh hiển thị `&nbsp;`, `&ecirc;` raw.

## Frontend

- **Desktop CSS**: `public/assets/css/style.css` — sprite-based, fixed pixel widths
- **Responsive overrides**: `<style>` block inline trong từng layout (main.php, post.php, category.php)
- **Swiper.js 6.5.8**: 2 instance riêng `.slide__pc` và `.slide__mobile`, scoped selectors
- **TinyMCE 8**: API key `mmrg5bvj98v0ftxqz9i5mjnkkohbp8nhjlj02grpxawn4ugg`
- **Mobile breakpoint**: `@media (max-width: 992px)` ẩn sidebar, hiện mobile-sections

## Mobile layout (main.php)

- `.mobile-top-sections`: download buttons + navbar — hiện trước news
- `.mobile-bottom-sections`: tính năng mới + hoạt động ngày — hiện sau news
- Sidebar trái/phải ẩn tại 992px, nội dung được duplicate vào mobile-sections

## Sprite images

Nhiều ảnh là sprite 2 trạng thái (normal + hover) xếp dọc:
- Normal: `background-position: top center`
- Hover: `background-position: bottom center`
- Khi scale: dùng `background-size: 100% 200%` để chỉ hiện 1 trạng thái
