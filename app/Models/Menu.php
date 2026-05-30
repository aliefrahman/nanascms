<?php

namespace App\Models;

use Core\Database;
use PDO;

class Menu
{
    /**
     * Fetch all menus with their parent's title joined.
     * Ordered by sort_order ASC, then id ASC.
     *
     * @return array
     */
    public static function all(): array
    {
        return Database::query(
            "SELECT m1.id, m1.title, m1.url, m1.parent_id, m1.sort_order, m2.title AS parent_title 
             FROM menus m1 
             LEFT JOIN menus m2 ON m1.parent_id = m2.id 
             ORDER BY m1.sort_order ASC, m1.id ASC"
        )->fetchAll();
    }

    /**
     * Find a single menu item by ID.
     *
     * @param int $id
     * @return array|null
     */
    public static function find(int $id): ?array
    {
        $stmt = Database::query("SELECT * FROM menus WHERE id = ?", [$id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    /**
     * Create a new menu record.
     *
     * @param array $data
     * @return bool
     */
    public static function create(array $data): bool
    {
        $parentId = !empty($data['parent_id']) && $data['parent_id'] !== 'root' ? (int) $data['parent_id'] : null;
        $sortOrder = isset($data['sort_order']) ? (int) $data['sort_order'] : 0;

        return Database::query(
            "INSERT INTO menus (title, url, parent_id, sort_order) VALUES (?, ?, ?, ?)",
            [
                trim($data['title']),
                trim($data['url']),
                $parentId,
                $sortOrder
            ]
        ) ? true : false;
    }

    /**
     * Update an existing menu record.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function update(int $id, array $data): bool
    {
        $parentId = !empty($data['parent_id']) && $data['parent_id'] !== 'root' ? (int) $data['parent_id'] : null;
        $sortOrder = isset($data['sort_order']) ? (int) $data['sort_order'] : 0;

        return Database::query(
            "UPDATE menus SET title = ?, url = ?, parent_id = ?, sort_order = ? WHERE id = ?",
            [
                trim($data['title']),
                trim($data['url']),
                $parentId,
                $sortOrder,
                $id
            ]
        ) ? true : false;
    }

    /**
     * Delete a menu item by ID.
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        return Database::query("DELETE FROM menus WHERE id = ?", [$id]) ? true : false;
    }
}
