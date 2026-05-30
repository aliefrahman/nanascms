<?php

namespace App\Models;

use Core\Database;

class Media {
    /**
     * Fetch all media files belonging to a specific user.
     *
     * @param int $userId
     * @return array
     */
    public static function allByUserId(int $userId): array {
        return Database::query(
            "SELECT * FROM media WHERE user_id = :user_id ORDER BY id DESC",
            ['user_id' => $userId]
        )->fetchAll();
    }

    /**
     * Find a media file by ID.
     *
     * @param int $id
     * @return array|null
     */
    public static function find(int $id): ?array {
        $stmt = Database::query(
            "SELECT * FROM media WHERE id = :id LIMIT 1",
            ['id' => $id]
        );
        $file = $stmt->fetch();
        return $file ?: null;
    }

    /**
     * Insert a new media file log into database.
     *
     * @param array $data Contains user_id, filename, original_name, file_path, file_type, file_size
     * @return int Last inserted ID
     */
    public static function create(array $data): int {
        $db = Database::connect();
        $stmt = $db->prepare(
            "INSERT INTO media (user_id, filename, original_name, file_path, file_type, file_size) 
             VALUES (:user_id, :filename, :original_name, :file_path, :file_type, :file_size)"
        );
        $stmt->execute([
            'user_id' => (int)$data['user_id'],
            'filename' => $data['filename'],
            'original_name' => $data['original_name'],
            'file_path' => $data['file_path'],
            'file_type' => $data['file_type'],
            'file_size' => (int)$data['file_size']
        ]);
        return (int)$db->lastInsertId();
    }

    /**
     * Delete media item by ID.
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool {
        Database::query("DELETE FROM media WHERE id = :id", ['id' => $id]);
        return true;
    }
}
