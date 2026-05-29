<?php

namespace Database\Seeders;

use App\Models\Categorie;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Categorie::pluck('categories_id', 'categories_name');

        if ($categoryIds->isEmpty()) {
            $this->call(CategorieSeeders::class);
            $categoryIds = Categorie::pluck('categories_id', 'categories_name');
        }

        $products = [
            ['Tra sua tran chau', 'Tra sua beo nhe, topping tran chau den dai ngon.', 'Tra sua', 'Tra-sua-tran-chau.png', 32000, 80],
            ['Sua tuoi tran chau duong den', 'Sua tuoi thom beo ket hop tran chau duong den.', 'Tra sua', 'suaTuoiTranChau.png', 35000, 70],
            ['Tra sua chai', 'Tra sua dong chai tien loi cho mang di.', 'Tra sua', 'traSuaChai.png', 28000, 90],
            ['Matcha latte', 'Matcha thanh mat, sua tuoi mem vi.', 'Ca phe', 'matchalate.png', 39000, 55],
            ['Ca phe muoi', 'Ca phe dam vi, lop kem muoi beo man nhe.', 'Ca phe', 'cafe-muoi.png', 29000, 65],
            ['Tra chanh mat ong', 'Tra chanh tuoi mat, ngot diu voi mat ong.', 'Tra trai cay', 'traChanhMatOng.png', 25000, 100],
            ['Hong tra dao', 'Hong tra thom, dao mieng gion ngot.', 'Tra trai cay', 'hongTraDao.png', 30000, 75],
            ['Tra trai cay hop', 'Tra trai cay dong hop tien loi, vi tuoi mat.', 'Tra trai cay', 'traTraiCayHop.png', 26000, 85],
            ['Nuoc cam tuoi', 'Cam tuoi vat trong ngay, giau vitamin C.', 'Trai cay tuoi', 'nuocCam.png', 30000, 60],
            ['Dua luoi cat san', 'Dua luoi tuoi, ngot thanh, hop dung tien loi.', 'Trai cay tuoi', 'duaLuoi.png', 45000, 40],
            ['Sau rieng', 'Sau rieng chin cay, com vang beo thom.', 'Trai cay tuoi', 'sau-rieng.png', 89000, 25],
            ['Mi tron cay', 'Mi tron sot cay, topping day dan.', 'Do an nhanh', 'mi-tron-cay.png', 42000, 50],
            ['Mi tron pho mai Han Quoc', 'Mi tron cay beo vi pho mai Han Quoc.', 'Do an nhanh', 'mi-tron-pho-mai-hq.png', 46000, 45],
            ['Mi Quang', 'Mi Quang dam da voi rau song va dau phong.', 'Dac san Viet', 'miquang.png', 55000, 35],
            ['Com chay cha bong', 'Com chay gion, cha bong man ngot vua mieng.', 'Dac san Viet', 'comChayChaBong.png', 38000, 65],
            ['Kho ga la chanh', 'Kho ga xe cay nhe, thom la chanh.', 'Dac san Viet', 'khoGaLaChanh.png', 69000, 40],
            ['Che duong nhan', 'Che mat lanh voi tuyet yen, nhan nhuc va tao do.', 'Dac san Viet', 'cheDuongNhan.png', 42000, 55],
            ['Tra moc thao xanh', 'Tra thao moc thanh loc, hau vi nhe.', 'Tra trai cay', 'tra-moc-thao-green.png', 24000, 70],
        ];

        foreach ($products as [$name, $description, $category, $image, $price, $quantity]) {
            Product::updateOrCreate(
                ['product_name' => $name],
                [
                    'product_image' => $image,
                    'categories_id' => $categoryIds[$category] ?? $categoryIds->first(),
                    'product_price' => $price,
                    'quantity_store' => $quantity,
                    'description' => $description,
                ]
            );
        }
    }
}
