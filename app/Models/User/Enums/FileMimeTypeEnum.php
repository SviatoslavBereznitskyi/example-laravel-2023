<?php

declare(strict_types=1);

namespace App\Models\User\Enums;

enum FileMimeTypeEnum: string
{
    case Jpg = 'jpg';
    case Jpeg = 'jpeg';
    case Png = 'png';
    case Doc = 'doc';
    case Docx = 'docx';
    case Pdf = 'pdf';
    case Gif = 'gif';
    case Zip = 'zip';
    case Rar = 'rar';
    case Tar = 'tar';
    case Txt = 'txt';
    case Xls = 'xls';
    case Xlsx = 'xlsx';
    case Odt = 'odt';

    public static function getList(): array
    {
        return array_map(static fn ($item) => $item->value, self::cases());
    }
}
