<?php

namespace App\Helpers;

class SettingsData
{
    public static function getStoreProfile()
    {
        return [
            'store_name' => 'Blue Technology POS',
            'phone' => '+855 12 345 678',
            'email' => 'contact@bluetech.com',
            'address' => 'No. 12, Street 271, Phnom Penh, Cambodia',
        ];
    }

    public static function getTaxCurrency()
    {
        return [
            'currency' => 'USD',
            'currency_symbol' => '$',
            'tax_rate' => 10,
            'tax_mode' => 'exclusive', // exclusive | inclusive
        ];
    }

    public static function getReceiptSettings()
    {
        return [
            'header_text' => 'Thank you for shopping with us!',
            'footer_text' => 'All sales are final after 7 days. Keep this receipt for warranty claims.',
            'show_logo' => true,
            'paper_size' => '80mm',
        ];
    }

    public static function getPaymentMethods()
    {
        return [
            ['code' => 'cash', 'name' => 'Cash', 'icon' => 'fa-solid fa-money-bill-wave', 'color' => '#0F6E8C', 'enabled' => true],
            ['code' => 'khqr', 'name' => 'KHQR', 'icon' => 'fa-solid fa-qrcode', 'color' => '#10B981', 'enabled' => true],
            ['code' => 'card', 'name' => 'Credit / Debit Card', 'icon' => 'fa-solid fa-credit-card', 'color' => '#8B5CF6', 'enabled' => true],
        ];
    }

    public static function getNotificationSettings()
    {
        return [
            'low_stock_alert' => true,
            'low_stock_threshold' => 10,
            'email_alerts' => true,
            'new_sale_alert' => false,
            'daily_summary' => true,
        ];
    }

    public static function getSyncStatus()
    {
        return [
            'last_synced' => '2024-11-25 10:42',
            'auto_sync' => true,
            'pending_records' => 0,
            'connection' => 'online',
        ];
    }
}