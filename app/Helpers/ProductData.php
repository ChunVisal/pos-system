<?php

namespace App\Helpers;

class ProductData
{
    public static function getProductsByCategory($categoryCode)
    {
        $products = [
            'CAT-CPU' => [
                ['name' => 'Intel Core i9-14900K',         'price' => 589.00],
                ['name' => 'Intel Core i7-14700K',         'price' => 409.00],
                ['name' => 'Intel Core i5-14600K',         'price' => 319.00],
                ['name' => 'AMD Ryzen 9 7950X',            'price' => 699.00],
                ['name' => 'AMD Ryzen 7 7800X3D',          'price' => 399.00],
                ['name' => 'AMD Ryzen 5 7600X',            'price' => 249.00],
                ['name' => 'Intel Core i3-14100F',         'price' => 109.00],
                ['name' => 'AMD Ryzen 9 7900X',            'price' => 449.00],
                ['name' => 'Intel Core i9-13900K',         'price' => 549.00],
                ['name' => 'AMD Ryzen Threadripper 7970X', 'price' => 2499.00],
            ],
            'CAT-GPU' => [
                ['name' => 'NVIDIA GeForce RTX 4090',      'price' => 1599.00],
                ['name' => 'NVIDIA GeForce RTX 4080 Super', 'price' => 999.00],
                ['name' => 'NVIDIA GeForce RTX 4070 Ti',   'price' => 799.00],
                ['name' => 'AMD Radeon RX 7900 XTX',       'price' => 899.00],
                ['name' => 'AMD Radeon RX 7800 XT',        'price' => 499.00],
                ['name' => 'NVIDIA GeForce RTX 4060',      'price' => 299.00],
                ['name' => 'AMD Radeon RX 7600',           'price' => 269.00],
                ['name' => 'Intel Arc A770',                'price' => 249.00],
                ['name' => 'NVIDIA GeForce RTX 4070 Super', 'price' => 599.00],
                ['name' => 'AMD Radeon RX 7700 XT',        'price' => 449.00],
            ],
            'CAT-RAM' => [
                ['name' => 'Corsair Vengeance DDR5 32GB',  'price' => 109.00],
                ['name' => 'G.Skill Trident Z5 RGB 32GB',  'price' => 129.00],
                ['name' => 'Kingston Fury Beast DDR5 16GB', 'price' => 59.00],
                ['name' => 'Crucial Pro DDR5 32GB',        'price' => 99.00],
                ['name' => 'TeamGroup T-Force Delta 32GB', 'price' => 95.00],
                ['name' => 'Corsair Dominator Platinum 64GB', 'price' => 229.00],
                ['name' => 'G.Skill Ripjaws S5 32GB',      'price' => 89.00],
                ['name' => 'Kingston Fury Renegade 32GB',  'price' => 119.00],
                ['name' => 'ADATA XPG Lancer 16GB',        'price' => 49.00],
                ['name' => 'Patriot Viper Venom 32GB',     'price' => 85.00],
            ],
            'CAT-SSD' => [
                ['name' => 'Samsung 990 PRO 2TB NVMe',     'price' => 159.00],
                ['name' => 'WD Black SN850X 2TB NVMe',     'price' => 149.00],
                ['name' => 'Crucial T700 2TB PCIe 5.0',    'price' => 189.00],
                ['name' => 'Kingston KC3000 1TB NVMe',     'price' => 89.00],
                ['name' => 'Samsung 870 EVO 2TB SATA',     'price' => 139.00],
                ['name' => 'Seagate FireCuda 530 1TB',     'price' => 99.00],
                ['name' => 'ADATA XPG Gammix S70 2TB',     'price' => 129.00],
                ['name' => 'Crucial MX500 1TB SATA',       'price' => 69.00],
                ['name' => 'SK Hynix Platinum P41 2TB',    'price' => 145.00],
                ['name' => 'TeamGroup Cardea A440 1TB',    'price' => 79.00],
            ],
            'CAT-MTB' => [
                ['name' => 'ASUS ROG Maximus Z790 Hero',   'price' => 629.00],
                ['name' => 'MSI MPG Z790 Carbon WiFi',     'price' => 449.00],
                ['name' => 'Gigabyte Z790 AORUS Master',   'price' => 499.00],
                ['name' => 'ASRock Z790 Taichi',           'price' => 399.00],
                ['name' => 'ASUS TUF Gaming B650-PLUS',    'price' => 199.00],
                ['name' => 'MSI MAG B760 Tomahawk',        'price' => 179.00],
                ['name' => 'Gigabyte B650 AORUS Elite',    'price' => 219.00],
                ['name' => 'ASUS ROG Strix X670E-E',       'price' => 499.00],
                ['name' => 'MSI MEG X670E Godlike',        'price' => 999.00],
                ['name' => 'ASRock B650M Pro RS',          'price' => 149.00],
            ],
            'CAT-PSU' => [
                ['name' => 'Corsair RM850x 850W',          'price' => 139.00],
                ['name' => 'EVGA SuperNOVA 1000 G7',       'price' => 189.00],
                ['name' => 'Seasonic Focus GX-750',        'price' => 129.00],
                ['name' => 'be quiet! Dark Power 13 850W', 'price' => 199.00],
                ['name' => 'Cooler Master V850 SFX',       'price' => 159.00],
                ['name' => 'Corsair HX1200 1200W',         'price' => 249.00],
                ['name' => 'Thermaltake Toughpower GF3 1000W', 'price' => 179.00],
                ['name' => 'NZXT C1000 Gold',              'price' => 169.00],
                ['name' => 'ASUS ROG Thor 1200P2',         'price' => 349.00],
                ['name' => 'SilverStone SX1000 Platinum',  'price' => 219.00],
            ],
            'CAT-CASE' => [
                ['name' => 'NZXT H7 Flow',                 'price' => 129.00],
                ['name' => 'Corsair 5000D Airflow',        'price' => 174.00],
                ['name' => 'Lian Li PC-O11 Dynamic',       'price' => 149.00],
                ['name' => 'Fractal Design Meshify 2',     'price' => 159.00],
                ['name' => 'Cooler Master HAF 700',        'price' => 299.00],
                ['name' => 'Phanteks Eclipse P500A',       'price' => 139.00],
                ['name' => 'be quiet! Silent Base 802',    'price' => 169.00],
                ['name' => 'Thermaltake Core P6',          'price' => 199.00],
                ['name' => 'Lian Li LANCOOL III',          'price' => 119.00],
                ['name' => 'Fractal Design North',         'price' => 109.00],
            ],
            'CAT-MNT' => [
                ['name' => 'ASUS ROG Swift PG27AQDM',      'price' => 799.00],
                ['name' => 'Samsung Odyssey G7 27"',       'price' => 599.00],
                ['name' => 'LG UltraGear 27GP950-B',       'price' => 699.00],
                ['name' => 'Dell Alienware AW3423DWF',     'price' => 899.00],
                ['name' => 'Gigabyte M28U 28"',            'price' => 449.00],
                ['name' => 'MSI Optix MAG274QRF-QD',       'price' => 349.00],
                ['name' => 'ViewSonic Elite XG270QG',      'price' => 399.00],
                ['name' => 'BenQ EX2710Q 27"',             'price' => 329.00],
                ['name' => 'Acer Predator X34',            'price' => 749.00],
                ['name' => 'HP OMEN 27k 27"',              'price' => 649.00],
            ],
            'CAT-CLG' => [
                ['name' => 'NZXT Kraken Z73 RGB',          'price' => 279.00],
                ['name' => 'Corsair iCUE H150i Elite',     'price' => 199.00],
                ['name' => 'Noctua NH-D15 Chromax',        'price' => 109.00],
                ['name' => 'Cooler Master Hyper 212',      'price' => 39.00],
                ['name' => 'be quiet! Dark Rock Pro 4',    'price' => 89.00],
                ['name' => 'Arctic Liquid Freezer II 360', 'price' => 129.00],
                ['name' => 'Deepcool LS720',               'price' => 119.00],
                ['name' => 'Lian Li Galahad 360',          'price' => 149.00],
                ['name' => 'Thermaltake TOUGHAIR 510',     'price' => 49.00],
                ['name' => 'EK-AIO Nucleus CR360',         'price' => 159.00],
            ],
            'CAT-KBD' => [
                ['name' => 'Razer Huntsman V3 Pro',        'price' => 199.00],
                ['name' => 'Corsair K100 RGB Optical',     'price' => 229.00],
                ['name' => 'Logitech G915 TKL Wireless',   'price' => 239.00],
                ['name' => 'SteelSeries Apex Pro',         'price' => 199.00],
                ['name' => 'Ducky One 3 Mini',             'price' => 109.00],
                ['name' => 'Keychron Q1 Pro',              'price' => 199.00],
                ['name' => 'ASUS ROG Azoth',               'price' => 249.00],
                ['name' => 'Wooting 60HE',                 'price' => 175.00],
                ['name' => 'HyperX Alloy Origins 65',      'price' => 89.00],
                ['name' => 'Razer BlackWidow V4',          'price' => 139.00],
            ],
            'CAT-MSE' => [
                ['name' => 'Logitech G502 X Plus',         'price' => 159.00],
                ['name' => 'Razer DeathAdder V3 Pro',      'price' => 149.00],
                ['name' => 'Logitech G Pro X Superlight',  'price' => 159.00],
                ['name' => 'SteelSeries Aerox 5',          'price' => 99.00],
                ['name' => 'Glorious Model O 2',           'price' => 79.00],
                ['name' => 'Razer Viper V2 Pro',           'price' => 149.00],
                ['name' => 'Corsair Dark Core RGB Pro',    'price' => 89.00],
                ['name' => 'Pulsar X2 Wireless',           'price' => 95.00],
                ['name' => 'Zowie EC2-CW',                 'price' => 129.00],
                ['name' => 'Razer Basilisk V3',            'price' => 69.00],
            ],
        ];

        return $products[$categoryCode] ?? [];
    }

    public static function getAllProducts(): array
    {
        $all = [];
        $codes = ['CAT-CPU', 'CAT-GPU', 'CAT-RAM', 'CAT-SSD', 'CAT-MTB',
            'CAT-PSU', 'CAT-CASE', 'CAT-MNT', 'CAT-CLG', 'CAT-KBD', 'CAT-MSE'];

        foreach ($codes as $code) {
            foreach (self::getProductsByCategory($code) as $product) {
                $all[] = array_merge($product, ['category_code' => $code]);
            }
        }

        return $all;
    }
}
