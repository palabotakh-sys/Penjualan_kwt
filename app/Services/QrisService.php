<?php

namespace App\Services;

use App\Models\Setting;

class QrisService {
    /**
     * Compute CRC16-CCITT for standard EMVCo QRIS.
     */
    public static function crc16(string $str): string {
        $crc = 0xFFFF;
        $len = strlen($str);
        for ($c = 0; $c < $len; $c++) {
            $crc ^= ord($str[$c]) << 8;
            for ($i = 0; $i < 8; $i++) {
                if ($crc & 0x8000) {
                    $crc = (($crc << 1) ^ 0x1021) & 0xFFFF;
                } else {
                    $crc = ($crc << 1) & 0xFFFF;
                }
            }
        }
        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }

    /**
     * Validate if string is a valid QRIS payload.
     */
    public static function isValidQris(?string $qris): bool {
        if (!$qris) return false;
        $qris = trim($qris);
        return str_starts_with($qris, '000201') && strlen($qris) >= 40;
    }

    /**
     * Convert static QRIS string (e.g. DANA Bisnis, GoPay, Bank) to Dynamic QRIS with amount.
     */
    public static function convertStaticToDynamic(string $staticQris, float|int $amount): string {
        $qris = trim($staticQris);

        // 1. Convert Tag 01 from 11 (Static) to 12 (Dynamic)
        if (str_starts_with($qris, '000201010211')) {
            $qris = '000201010212' . substr($qris, 12);
        } else {
            $qris = str_replace('010211', '010212', $qris);
        }

        // 2. Strip existing CRC (Tag 63)
        if (preg_match('/6304[0-9A-Fa-f]{4}$/', $qris)) {
            $qris = substr($qris, 0, -8);
        }

        // Format new Tag 54 (Amount)
        $amt = (int) round($amount);
        $amtStr = (string) $amt;
        $tag54 = '54' . sprintf('%02d', strlen($amtStr)) . $amtStr;

        // 3. Insert or Replace Tag 54 between Currency (5303360) and Country Code (5802)
        $pos53 = strpos($qris, '5303360');
        $pos58 = strpos($qris, '5802');

        if ($pos53 !== false && $pos58 !== false && $pos58 > $pos53) {
            $part1 = substr($qris, 0, $pos53 + 7);
            $part2 = substr($qris, $pos58);
            $qris = $part1 . $tag54 . $part2;
        } elseif ($pos58 !== false) {
            $qris = substr($qris, 0, $pos58) . $tag54 . substr($qris, $pos58);
        } else {
            $qris .= $tag54;
        }

        // 4. Recalculate CRC16
        $payload = $qris . '6304';
        $crc = self::crc16($payload);
        return $payload . $crc;
    }

    /**
     * Generate QR code image URL from payload.
     */
    public static function getQrImageUrl(string $payload): string {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=350x350&margin=10&data=' . urlencode($payload);
    }

    /**
     * Get dynamic QRIS data for an order or transaction.
     */
    public static function getDynamicQrisData(float|int $amount, ?string $customStaticQris = null): array {
        $staticQris = $customStaticQris ?: Setting::get('qris_static_string');
        $merchantName = Setting::get('qris_merchant_name', 'KWT Ariyad Jaya');
        $isActive = Setting::get('qris_enabled', '1') === '1';

        if (!self::isValidQris($staticQris)) {
            return [
                'is_configured' => false,
                'is_active' => $isActive,
                'error' => 'String QRIS belum dikonfigurasi oleh admin.',
                'payload' => null,
                'qr_url' => null,
                'amount' => (int) $amount,
                'formatted_amount' => 'Rp ' . number_format($amount, 0, ',', '.'),
                'merchant_name' => $merchantName,
            ];
        }

        $dynamicPayload = self::convertStaticToDynamic($staticQris, $amount);
        $qrUrl = self::getQrImageUrl($dynamicPayload);

        return [
            'is_configured' => true,
            'is_active' => $isActive,
            'error' => null,
            'payload' => $dynamicPayload,
            'qr_url' => $qrUrl,
            'amount' => (int) $amount,
            'formatted_amount' => 'Rp ' . number_format($amount, 0, ',', '.'),
            'merchant_name' => $merchantName,
        ];
    }
}

