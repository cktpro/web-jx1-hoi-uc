<?php

function url_slug(string $str): string {
    $str = mb_strtolower($str, 'UTF-8');
    $map = [
        'á'=>'a','à'=>'a','ả'=>'a','ã'=>'a','ạ'=>'a','ă'=>'a','ắ'=>'a','ằ'=>'a','ẳ'=>'a','ẵ'=>'a','ặ'=>'a',
        'â'=>'a','ấ'=>'a','ầ'=>'a','ẩ'=>'a','ẫ'=>'a','ậ'=>'a','đ'=>'d',
        'é'=>'e','è'=>'e','ẻ'=>'e','ẽ'=>'e','ẹ'=>'e','ê'=>'e','ế'=>'e','ề'=>'e','ể'=>'e','ễ'=>'e','ệ'=>'e',
        'í'=>'i','ì'=>'i','ỉ'=>'i','ĩ'=>'i','ị'=>'i',
        'ó'=>'o','ò'=>'o','ỏ'=>'o','õ'=>'o','ọ'=>'o','ô'=>'o','ố'=>'o','ồ'=>'o','ổ'=>'o','ỗ'=>'o','ộ'=>'o',
        'ơ'=>'o','ớ'=>'o','ờ'=>'o','ở'=>'o','ỡ'=>'o','ợ'=>'o',
        'ú'=>'u','ù'=>'u','ủ'=>'u','ũ'=>'u','ụ'=>'u','ư'=>'u','ứ'=>'u','ừ'=>'u','ử'=>'u','ữ'=>'u','ự'=>'u',
        'ý'=>'y','ỳ'=>'y','ỷ'=>'y','ỹ'=>'y','ỵ'=>'y',
    ];
    $str = str_replace(array_keys($map), $map, $str);
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', '-', $str);
    $str = trim($str, '-');
    return $str ?: 'n-a';
}

function post_url(array $post): string {
    $slug = $post['Slug'] ?? url_slug($post['Title'] ?? '');
    return '/' . ($slug ?: $post['ID']) . '.html';
}

function siteconfig_load(): array {
    $file = APP_PATH . '/storage/siteconfig.json';
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?? [];
}

function siteconfig_save(array $data): void {
    file_put_contents(
        APP_PATH . '/storage/siteconfig.json',
        json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
    );
}

function hoatdong_load(): array {
    $file = APP_PATH . '/storage/hoatdong.json';
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true) ?? [];
}

function hoatdong_save(array $data): void {
    file_put_contents(
        APP_PATH . '/storage/hoatdong.json',
        json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
    );
}
