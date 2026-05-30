<?php

namespace Core;

class Auth {
    private static ?array $user = null;

    /**
     * Check if a user session is active.
     *
     * @return bool
     */
    public static function check(): bool {
        return isset($_SESSION['user_id']);
    }

    /**
     * Get the currently logged-in user data.
     *
     * @return array|null
     */
    public static function user(): ?array {
        if (!self::check()) {
            return null;
        }

        if (self::$user === null) {
            self::$user = \App\Models\User::find($_SESSION['user_id']);
        }

        return self::$user;
    }

    /**
     * Get the role name of the currently logged-in user.
     *
     * @return string|null (e.g. 'Admin', 'Editor', 'Author')
     */
    public static function role(): ?string {
        $user = self::user();
        return $user ? $user['role_name'] : null;
    }

    /**
     * Check if the logged-in user matches a specific role name.
     *
     * @param string $roleName Case-insensitive role comparison
     * @return bool
     */
    public static function hasRole(string $roleName): bool {
        $userRole = self::role();
        return $userRole && strtolower($userRole) === strtolower($roleName);
    }

    /**
     * Log in a user by storing their ID in session state.
     *
     * @param int $userId
     */
    public static function login(int $userId): void {
        $_SESSION['user_id'] = $userId;
        self::$user = null; // Flush internal memory cache
    }

    /**
     * Terminate the session and log out the user.
     */
    public static function logout(): void {
        if (isset($_SESSION['user_id'])) {
            unset($_SESSION['user_id']);
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
        self::$user = null;
    }
}
