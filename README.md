# FoodDS - Website Ban Do An

FoodDS la project Laravel cho website ban do an/thuc uong, co cac luong chinh cho khach hang va quan tri:

- Xem danh sach san pham, tim kiem, sap xep theo gia, xem san pham yeu thich.
- Xem chi tiet san pham, danh gia san pham sau khi mua hang.
- Them gio hang, dat nhieu san pham, thanh toan COD/VNPay/ZaloPay.
- Dang ky, dang nhap, quen mat khau bang OTP email.
- Quan tri san pham, danh muc, khach hang, nhan vien, khuyen mai va thong ke.
- Xuat Excel/PDF cho mot so bao cao.

## Cong nghe

- PHP 8.2+
- Laravel 12
- MySQL hoac database tuong thich Laravel
- Vite
- Tailwind CSS 4
- Bootstrap/MDB cho mot so man hinh cu
- Laravel Socialite, DomPDF, Maatwebsite Excel

## Cai dat

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Cap nhat thong tin database trong file `.env`, sau do chay:

```bash
php artisan migrate --seed
```

Neu chi muon nap lai du lieu mau:

```bash
php artisan db:seed
```

## Chay project

Chay server Laravel:

```bash
php artisan serve
```

Chay Vite de bien dich Tailwind:

```bash
npm run dev
```

Mo trang chinh:

```text
http://127.0.0.1:8000/food_ds.com
```

## Build giao dien

```bash
npm run build
```

## Ghi chu du lieu mau

Seeder hien tao danh muc va nhieu san pham do an/thuc uong voi anh co san trong `public/component/image-product`. Neu them anh moi, hay dat file vao thu muc nay va cap nhat `database/seeders/ProductsSeeder.php`.
