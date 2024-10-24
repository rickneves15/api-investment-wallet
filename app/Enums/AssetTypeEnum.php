<?php

namespace App\Enums;

enum AssetTypeEnum: string
{
    case ACTION = 'action';
    case REAL_ESTATE = 'real estate';
    case FIXED_INCOME = 'fixed income';
    case CRYPTOCURRENCY = 'cryptocurrency';
}
