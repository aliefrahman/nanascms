<?php

namespace App\Models;

use Core\Database;

class User {
    /**
     * Fetch all users along with their role names.
     *
     * @return array
     */
    public static function all(): array {
        return Database::query(
            "SELECT u.id, u.username, u.fullname, u.email, u.avatar, r.name as role_name, u.created_at 
             FROM users u 
             INNER JOIN roles r ON u.role_id = r.id 
             ORDER BY u.id ASC"
        )->fetchAll();
    }

    /**
     * Find a user record by ID, including their role name.
     *
     * @param int $id
     * @return array|null
     */
    public static function find(int $id): ?array {
        $stmt = Database::query(
            "SELECT u.id, u.username, u.fullname, u.email, u.avatar, u.role_id, r.name as role_name, u.created_at 
             FROM users u 
             INNER JOIN roles r ON u.role_id = r.id 
             WHERE u.id = :id 
             LIMIT 1",
            ['id' => $id]
        );
        $user = $stmt->fetch();
        return $user ?: null;
    }

    /**
     * Find a user by username or email. Used for authentication login.
     *
     * @param string $login Username or email input string
     * @return array|null
     */
    public static function findByUsernameOrEmail(string $login): ?array {
        $stmt = Database::query(
            "SELECT * FROM users WHERE username = :username OR email = :email LIMIT 1",
            [
                'username' => $login,
                'email' => $login
            ]
        );
        $user = $stmt->fetch();
        return $user ?: null;
    }

    /**
     * Insert a new user into the database.
     *
     * @param array $data Contains username, email, password_hash, and role_id
     * @return bool
     */
    public static function create(array $data): bool {
        Database::query(
            "INSERT INTO users (username, fullname, email, avatar, password_hash, role_id) VALUES (:username, :fullname, :email, :avatar, :password_hash, :role_id)",
            [
                'username' => $data['username'],
                'fullname' => $data['fullname'] ?? null,
                'email' => $data['email'],
                'avatar' => $data['avatar'] ?? null,
                'password_hash' => $data['password_hash'],
                'role_id' => $data['role_id']
            ]
        );
        return true;
    }

    /**
     * Update user details.
     *
     * @param int $id User ID
     * @param array $data Contains username, email, role_id, and optional password_hash
     * @return bool
     */
    public static function update(int $id, array $data): bool {
        if (!empty($data['password_hash'])) {
            Database::query(
                "UPDATE users SET username = :username, fullname = :fullname, email = :email, avatar = :avatar, password_hash = :password_hash, role_id = :role_id WHERE id = :id",
                [
                    'username' => $data['username'],
                    'fullname' => $data['fullname'] ?? null,
                    'email' => $data['email'],
                    'avatar' => $data['avatar'] ?? null,
                    'password_hash' => $data['password_hash'],
                    'role_id' => $data['role_id'],
                    'id' => $id
                ]
            );
        } else {
            Database::query(
                "UPDATE users SET username = :username, fullname = :fullname, email = :email, avatar = :avatar, role_id = :role_id WHERE id = :id",
                [
                    'username' => $data['username'],
                    'fullname' => $data['fullname'] ?? null,
                    'email' => $data['email'],
                    'avatar' => $data['avatar'] ?? null,
                    'role_id' => $data['role_id'],
                    'id' => $id
                ]
            );
        }
        return true;
    }

    /**
     * Delete a user by ID.
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool {
        Database::query("DELETE FROM users WHERE id = :id", ['id' => $id]);
        return true;
    }

    /**
     * Check if a username is already taken.
     *
     * @param string $username
     * @param int|null $excludeId Optional ID to exclude from comparison (used for updates)
     * @return bool
     */
    public static function existsUsername(string $username, ?int $excludeId = null): bool {
        if ($excludeId !== null) {
            $stmt = Database::query(
                "SELECT id FROM users WHERE username = :username AND id != :id LIMIT 1",
                ['username' => $username, 'id' => $excludeId]
            );
        } else {
            $stmt = Database::query(
                "SELECT id FROM users WHERE username = :username LIMIT 1",
                ['username' => $username]
            );
        }
        return (bool)$stmt->fetch();
    }

    /**
     * Check if an email is already registered.
     *
     * @param string $email
     * @param int|null $excludeId Optional ID to exclude from comparison (used for updates)
     * @return bool
     */
    public static function existsEmail(string $email, ?int $excludeId = null): bool {
        if ($excludeId !== null) {
            $stmt = Database::query(
                "SELECT id FROM users WHERE email = :email AND id != :id LIMIT 1",
                ['email' => $email, 'id' => $excludeId]
            );
        } else {
            $stmt = Database::query(
                "SELECT id FROM users WHERE email = :email LIMIT 1",
                ['email' => $email]
            );
        }
        return (bool)$stmt->fetch();
    }
}
