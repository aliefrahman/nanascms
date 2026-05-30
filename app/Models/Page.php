<?php

namespace App\Models;

use Core\Database;
use PDO;

class Page
{
    /**
     * Fetch all pages, ordered by created_at DESC.
     *
     * @return array
     */
    public static function all(): array
    {
        return Database::query("SELECT * FROM pages ORDER BY created_at DESC")->fetchAll();
    }

    /**
     * Fetch all published pages.
     *
     * @return array
     */
    public static function allPublished(): array
    {
        return Database::query("SELECT * FROM pages WHERE status = 'published' ORDER BY created_at DESC")->fetchAll();
    }

    /**
     * Find a page by ID.
     *
     * @param int $id
     * @return array|null
     */
    public static function find(int $id): ?array
    {
        $stmt = Database::query("SELECT * FROM pages WHERE id = ?", [$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Find a page by slug.
     *
     * @param string $slug
     * @return array|null
     */
    public static function findBySlug(string $slug): ?array
    {
        $stmt = Database::query("SELECT * FROM pages WHERE slug = ?", [$slug]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Create a new page record.
     *
     * @param array $data
     * @return bool
     */
    public static function create(array $data): bool
    {
        $title = trim($data['title']);
        $slug = !empty($data['slug']) ? self::slugify($data['slug']) : self::slugify($title);
        $content = $data['content'];
        $status = $data['status'] ?? 'draft';

        // Check if slug is unique, if not append number
        $slug = self::makeUniqueSlug($slug);

        return Database::query(
            "INSERT INTO pages (title, slug, content, status) VALUES (?, ?, ?, ?)",
            [$title, $slug, $content, $status]
        ) ? true : false;
    }

    /**
     * Update an existing page record.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function update(int $id, array $data): bool
    {
        $title = trim($data['title']);
        $slug = !empty($data['slug']) ? self::slugify($data['slug']) : self::slugify($title);
        $content = $data['content'];
        $status = $data['status'] ?? 'draft';

        // Check if slug is unique excluding this page
        $slug = self::makeUniqueSlug($slug, $id);

        return Database::query(
            "UPDATE pages SET title = ?, slug = ?, content = ?, status = ? WHERE id = ?",
            [$title, $slug, $content, $status, $id]
        ) ? true : false;
    }

    /**
     * Delete a page record.
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        return Database::query("DELETE FROM pages WHERE id = ?", [$id]) ? true : false;
    }

    /**
     * Generate unique slug by appending counter if needed.
     *
     * @param string $slug
     * @param int|null $excludeId
     * @return string
     */
    private static function makeUniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            if ($excludeId !== null) {
                $stmt = Database::query("SELECT COUNT(*) FROM pages WHERE slug = ? AND id != ?", [$slug, $excludeId]);
            } else {
                $stmt = Database::query("SELECT COUNT(*) FROM pages WHERE slug = ?", [$slug]);
            }

            if ((int) $stmt->fetchColumn() === 0) {
                return $slug;
            }
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
    }

    /**
     * Format a string into a URL-friendly slug.
     *
     * @param string $text
     * @return string
     */
    public static function slugify(string $text): string
    {
        // lower case
        $text = strtolower($text);
        // replace non-alphanumeric with -
        $text = preg_replace('/[^a-z0-9\-]/', '-', $text);
        // clean up multiple dashes
        $text = preg_replace('/-+/', '-', $text);
        // trim dashes from ends
        $text = trim($text, '-');
        return empty($text) ? 'page' : $text;
    }
}
