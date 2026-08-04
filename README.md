# 🍜 Foods - Website Bán Đặc Sản Quê Hương

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge\&logo=php\&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge\&logo=laravel\&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge\&logo=mysql\&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge\&logo=bootstrap\&logoColor=white)

**Website Thương Mại Điện Tử Chuyên Kinh Doanh Đặc Sản Vùng Miền**

</div>

---

Link website: tranvietgiangbe.id.vn/foods

## 📌 Giới Thiệu

Foods là website thương mại điện tử được xây dựng nhằm quảng bá và kinh doanh các món ăn, thức uống đặc sản quê hương đến với khách hàng trên toàn quốc.

Dự án ra đời từ mong muốn mang những hương vị truyền thống quê nhà đến gần hơn với những người con xa quê cũng như giới thiệu nét văn hóa ẩm thực đặc sắc của từng vùng miền đến đông đảo người tiêu dùng.

---

## 🎯 Mục Tiêu

* Quảng bá các đặc sản vùng miền đến khách hàng trên toàn quốc.
* Hỗ trợ mua sắm trực tuyến nhanh chóng và tiện lợi.
* Tạo môi trường kinh doanh trực tuyến hiệu quả cho nhà cung cấp.
* Nâng cao trải nghiệm mua hàng của người dùng.
* Góp phần bảo tồn và phát triển giá trị ẩm thực địa phương.

---

## ✨ Chức Năng Chính

### 👤 Khách Hàng

* Đăng ký / Đăng nhập tài khoản
* Tìm kiếm sản phẩm
* Xem chi tiết sản phẩm
* Thêm sản phẩm vào giỏ hàng
* Đặt hàng trực tuyến
* Theo dõi trạng thái đơn hàng
* Đánh giá sản phẩm
* Quản lý thông tin cá nhân

### 🛒 Quản Lý Sản Phẩm

* Thêm sản phẩm mới
* Chỉnh sửa sản phẩm
* Xóa sản phẩm
* Quản lý danh mục sản phẩm
* Quản lý hình ảnh sản phẩm

### 📦 Quản Lý Đơn Hàng

* Xem danh sách đơn hàng
* Cập nhật trạng thái đơn hàng
* Quản lý lịch sử giao dịch

### 👨‍💼 Quản Trị Viên

* Quản lý người dùng
* Quản lý sản phẩm
* Quản lý đơn hàng
* Thống kê doanh thu
* Quản lý danh mục

---

## 🛠 Công Nghệ Sử Dụng

| Thành phần      | Công nghệ              |
| --------------- | ---------------------- |
| Frontend        | HTML, CSS, Bootstrap 5 |
| Backend         | PHP Laravel            |
| Database        | MySQL                  |
| Web Server      | Apache                 |
| IDE             | Visual Studio Code     |
| Version Control | Git & GitHub           |

---

## 🏗 Kiến Trúc Hệ Thống

```text
Client Browser
       │
       ▼
Apache Web Server
       │
       ▼
Laravel Application
       │
       ▼
MySQL Database
```

---

## 📂 Cấu Trúc Thư Mục

```bash
foods/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── vendor/
├── artisan
├── composer.json
└── README.md
```

---

## ⚙️ Cài Đặt Dự Án

### Clone Source

```bash
git clone https://github.com/your-account/foods.git
cd foods
```

### Cài Đặt Thư Viện

```bash
composer install
```

### Tạo File Môi Trường

```bash
cp .env.example .env
```

### Sinh Key Laravel

```bash
php artisan key:generate
```

### Cấu Hình Database

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foods
DB_USERNAME=root
DB_PASSWORD=
```

### Chạy Migration

```bash
php artisan migrate
```

### Khởi Động Website

```bash
php artisan serve
```

Mặc định website sẽ chạy tại:

```text
http://127.0.0.1:8000
```

---

## 📸 Các Chức Năng Nổi Bật

* Giao diện thân thiện với người dùng
* Responsive trên điện thoại và máy tính
* Tìm kiếm sản phẩm nhanh chóng
* Quản lý đơn hàng hiệu quả
* Thanh toán thuận tiện
* Theo dõi trạng thái đơn hàng
* Đánh giá và nhận xét sản phẩm

---

## 📄 Giấy Phép

Dự án được phát triển nhằm mục đích học tập, nghiên cứu và phát triển kỹ năng lập trình web.

---



<div align="center">

Made with ❤️ by Foods Team

</div>
