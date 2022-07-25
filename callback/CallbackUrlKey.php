<?php

try {
    print_r("生成key:\r\n");
    print_r(strtoupper(CallbackUrlKey::generateKey()));
    print_r("\r\n");
} catch (Exception $e) {
    echo $e;
}

class CallbackUrlKey {
    public static function generateKey() {
        return sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}