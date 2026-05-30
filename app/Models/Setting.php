<?php

namespace App\Models;

use Core\Database;

class Setting
{
    /**
     * Dapatkan satu baris data pengaturan utama.
     *
     * @return array|null
     */
    public static function getSettings(): ?array
    {
        $stmt = Database::query("SELECT * FROM settings ORDER BY id ASC LIMIT 1");
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Dapatkan nilai dari salah satu kolom pengaturan.
     *
     * @param string $column
     * @return string|null
     */
    public static function get(string $column): ?string
    {
        $settings = self::getSettings();
        return $settings[$column] ?? null;
    }

    /**
     * Perbarui atau simpan (upsert) baris pengaturan.
     *
     * @param array $data
     * @return bool
     */
    public static function updateSettings(array $data): bool
    {
        $existing = self::getSettings();

        if ($existing) {
            Database::query(
                "UPDATE settings SET logo = :logo, brand_name = :brand_name, company_name = :company_name, tagline = :tagline, description = :description, address = :address, contact_number = :contact_number, company_email = :company_email, latitude = :latitude, longitude = :longitude WHERE id = :id",
                [
                    'logo' => $data['logo'],
                    'brand_name' => $data['brand_name'],
                    'company_name' => $data['company_name'],
                    'tagline' => $data['tagline'],
                    'description' => $data['description'],
                    'address' => $data['address'],
                    'contact_number' => $data['contact_number'],
                    'company_email' => $data['company_email'],
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude'],
                    'id' => $existing['id']
                ]
            );
        } else {
            Database::query(
                "INSERT INTO settings (logo, brand_name, company_name, tagline, description, address, contact_number, company_email, latitude, longitude) VALUES (:logo, :brand_name, :company_name, :tagline, :description, :address, :contact_number, :company_email, :latitude, :longitude)",
                [
                    'logo' => $data['logo'],
                    'brand_name' => $data['brand_name'],
                    'company_name' => $data['company_name'],
                    'tagline' => $data['tagline'],
                    'description' => $data['description'],
                    'address' => $data['address'],
                    'contact_number' => $data['contact_number'],
                    'company_email' => $data['company_email'],
                    'latitude' => $data['latitude'],
                    'longitude' => $data['longitude']
                ]
            );
        }
        return true;
    }
}
