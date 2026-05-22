<?php

function getDetailKostumGallery(string $pageKey): array {
    switch ($pageKey) {
        case 'detail_kostum':
            return [
                [
                    'foto' => '../assets/fotokostum4.jpeg',
                    'judul' => 'Adat Jawa',
                    'harga' => 6000000
                ],
                [
                    'foto' => '../assets/adatjawa.jpeg',
                    'judul' => 'Adat Sunda',
                    'harga' => 6000000
                ],
                [
                    'foto' => '../assets/fotokostum5.jpeg',
                    'judul' => 'Adat Bali',
                    'harga' => 6000000
                ],
                [
                    'foto' => '../assets/adatmadura.jpeg',
                    'judul' => 'Adat Madura',
                    'harga' => 6000000
                ],
            ];
        case 'detailkostum_wedding':
            return [
                [
                    'foto' => '../assets/fotokostum4.jpeg',
                    'judul' => 'Baju Akad Nikah',
                    'harga' => 4000000
                ],
                [
                    'foto' => '../assets/adatjawa.jpeg',
                    'judul' => 'Baju Resepsi',
                    'harga' => 4000000
                ],
                [
                    'foto' => '../assets/fotokostum5.jpeg',
                    'judul' => 'Baju Akad Nikah',
                    'harga' => 4000000
                ],
                [
                    'foto' => '../assets/adatmadura.jpeg',
                    'judul' => 'Baju Resepsi',
                    'harga' => 4000000
                ],
            ];
        case 'detailkostum_graduation':
            return [
                [
                    'foto' => '../assets/fotokostum4.jpeg',
                    'judul' => 'Jas Laki-laki',
                    'harga' => 6000000
                ],
                [
                    'foto' => '../assets/adatjawa.jpeg',
                    'judul' => 'Kebaya',
                    'harga' => 6000000
                ],
                [
                    'foto' => '../assets/fotokostum5.jpeg',
                    'judul' => 'Jas Laki-laki 2',
                    'harga' => 6000000
                ],
                [
                    'foto' => '../assets/adatmadura.jpeg',
                    'judul' => 'Kebaya 2',
                    'harga' => 6000000
                ],
            ];
        case 'detailkostum_pahlawan':
            return [
                [
                    'foto' => '../assets/fotokostum4.jpeg',
                    'judul' => 'Baju Pahlawan anak laki-laki',
                    'harga' => 2000000
                ],
                [
                    'foto' => '../assets/adatjawa.jpeg',
                    'judul' => 'Baju Pahlawan anak perempuan',
                    'harga' => 2000000
                ],
                [
                    'foto' => '../assets/fotokostum5.jpeg',
                    'judul' => 'Baju Pahlawan anak laki-laki',
                    'harga' => 2000000
                ],
                [
                    'foto' => '../assets/adatmadura.jpeg',
                    'judul' => 'Baju Pahlawan anak perempuan',
                    'harga' => 2000000
                ],
            ];
        default:
            return [];
    }
}
