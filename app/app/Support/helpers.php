<?php

if (! function_exists('generateProductCode')) {
    function generateProductCode(): string
    {
        $year = date('Y');
        $suffix = str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        return "PRD-{$year}-{$suffix}";
    }
}
