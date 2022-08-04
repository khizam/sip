<?php

namespace App\Models\Enums;

abstract class StatusProduksiEnum {
    const Terima = 1;
    const Proses = 2;
    const Selesai = 3;
    const Tolak = 4;
}
