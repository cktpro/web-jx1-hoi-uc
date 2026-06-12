# CLAUDE.md — Hướng dẫn cho Claude Code

## Kiến trúc

PHP 8.1 MVC tự xây, không dùng framework. Entry point duy nhất: `public/index.php`.

- **Router** (`core/Router.php`): match GET/POST/HEAD, dispatch tới Controller::method
- **Controller** (`core/Controller.php`): base class có `view()`, `authAdmin()`, `redirect()`
- **Model** (`core/Model.php`): base class wrapper PDO
- **Autoload**: `spl_autoload_register` tìm trong `app/Controllers/` và `app/Models/`

## Hai database

```php
db_portal()  // MySQL: gcpos   — tài khoản, thanh toán, máy chủ game
db_blog()    // MySQL: homejx  — bài viết, slide, SEO, hoạt động ngày, config
```

## Thêm route mới

Khai báo trong `public/index.php`:
```php
$router->get('/duong-dan', [Controller::class, 'method']);
$router->post('/duong-dan', [Controller::class, 'method']);
```

## Layouts

Mỗi trang dùng một layout riêng, truyền qua `$this->view()`:

| Layout | File |
|--------|------|
| Trang chủ | `app/Views/layouts/main.php` |
| Chi tiết bài | `app/Views/layouts/post.php` |
| Danh mục | `app/Views/layouts/category.php` |
| Admin | `app/Views/layouts/admin.php` |
| Người chơi | `app/Views/layouts/user.php` |

Layout include `$content_view` — tên view tương đối từ `app/Views/`.

## Auth admin

```php
// Trong Controller method:
$this->authAdmin(); // redirect về /admin/login nếu chưa đăng nhập
```

Session key: `$_SESSION['blog_admin']` (không phải `useradmin`).

## PostController

- Method show bài viết: `show(string $slug)` — **không dùng** `view()` (trùng tên base class)
- Category slug lấy từ `parse_url($_SERVER['REQUEST_URI'])`, không qua param
- Related posts dùng `GROUP BY p.postID` thay vì `SELECT DISTINCT` (tránh lỗi MySQL 3065)

## Excerpt bài viết

```php
mb_substr(strip_tags(html_entity_decode($content, ENT_QUOTES | ENT_HTML5, 'UTF-8')), 0, 200)
```

Luôn decode HTML entities trước khi strip_tags để tránh hiển thị `&nbsp;`, `&ecirc;` raw.

## Frontend

- **Desktop CSS**: `public/assets/css/style.css` — sprite-based, fixed pixel widths
- **Responsive overrides**: `<style>` block trong từng layout (main.php, post.php, category.php)
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

## Docker

```bash
docker-compose up -d    # khởi động (port 8090)
docker-compose down     # dừng
```

Database được init từ `docker/` khi container tạo lần đầu.
