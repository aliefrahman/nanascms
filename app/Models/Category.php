<?php

namespace App\Models;

use Core\Database;
use PDO;

class Category {
    /**
     * Fetch all categories sorted by name.
     */
    public static function all(): array {
        return Database::query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
    }

    /**
     * Fetch a single category by its ID.
     */
    public static function find(int $id): ?array {
        $stmt = Database::query("SELECT * FROM categories WHERE id = ?", [$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Fetch a single category by its slug.
     */
    public static function findBySlug(string $slug): ?array {
        $stmt = Database::query("SELECT * FROM categories WHERE slug = ?", [$slug]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Create a new category record.
     */
    public static function create(array $data): bool {
        return Database::query(
            "INSERT INTO categories (name, slug, description) VALUES (?, ?, ?)",
            [
                $data['name'],
                $data['slug'],
                $data['description'] ?? null
            ]
        ) ? true : false;
    }

    /**
     * Update an existing category record.
     */
    public static function update(int $id, array $data): bool {
        return Database::query(
            "UPDATE categories SET name = ?, slug = ?, description = ? WHERE id = ?",
            [
                $data['name'],
                $data['slug'],
                $data['description'] ?? null,
                $id
            ]
        ) ? true : false;
    }

    /**
     * Delete a category by its ID.
     */
    public static function delete(int $id): bool {
        return Database::query("DELETE FROM categories WHERE id = ?", [$id]) ? true : false;
    }

    /**
     * Check if a slug already exists (optionally excluding a specific ID).
     */
    public static function existsSlug(string $slug, ?int $excludeId = null): bool {
        if ($excludeId !== null) {
            $stmt = Database::query("SELECT COUNT(*) FROM categories WHERE slug = ? AND id != ?", [$slug, $excludeId]);
        } else {
            $stmt = Database::query("SELECT COUNT(*) FROM categories WHERE slug = ?", [$slug]);
        }
        return (int)$stmt->fetchColumn() > 0;
    }

    /**
     * Generate slug from a text.
     */
    public static function generateSlug(string $title): string {
        $slug = strtolower($title);
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        return trim($slug, '-');
    }

    /**
     * Get a unique slug. If the generated slug exists, appends counter suffix.
     */
    public static function getUniqueSlug(string $name, ?int $excludeId = null): string {
        $baseSlug = self::generateSlug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (self::existsSlug($slug, $excludeId)) {
            $counter++;
            $slug = $baseSlug . '-' . $counter;
        }

        return $slug;
    }
}
