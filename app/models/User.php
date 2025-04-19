<?php
/**
 * User Model
 * File: app/models/User.php
 */

class User extends Model {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Authenticate user
     */
    public function login($username, $password, $role = null) {
        // Prepare query
        $query = 'SELECT * FROM users WHERE username = :username';
        if ($role) {
            $query .= ' AND role = :role';
        }
        
        $this->db->query($query);
        $this->db->bind(':username', $username);
        if ($role) {
            $this->db->bind(':role', $role);
        }

        $row = $this->db->single();

        // Verify user exists and password is correct
        if ($row && password_verify($password, $row->password)) {
            return $row;
        }
        return false;
    }

    /**
     * Get user by ID
     */
    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Check if username exists
     */
    public function findUserByUsername($username) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        $row = $this->db->single();
        return $row ? true : false;
    }

    /**
     * Check if email exists
     */
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        return $row ? true : false;
    }

    /**
     * Create password reset token
     */
    public function createPasswordReset($email, $token, $expires) {
        $this->db->query('UPDATE users SET reset_token = :token, reset_expires = :expires WHERE email = :email');
        $this->db->bind(':token', $token);
        $this->db->bind(':expires', $expires);
        $this->db->bind(':email', $email);
        return $this->db->execute();
    }

    /**
     * Find user by reset token
     */
    public function findUserByResetToken($token) {
        $this->db->query('SELECT * FROM users WHERE reset_token = :token AND reset_expires > NOW()');
        $this->db->bind(':token', $token);
        return $this->db->single();
    }

    /**
     * Update user password
     */
    public function updatePassword($email, $password) {
        $this->db->query('UPDATE users SET password = :password WHERE email = :email');
        $this->db->bind(':password', $password);
        $this->db->bind(':email', $email);
        return $this->db->execute();
    }

    /**
     * Delete reset token
     */
    public function deleteResetToken($email) {
        $this->db->query('UPDATE users SET reset_token = NULL, reset_expires = NULL WHERE email = :email');
        $this->db->bind(':email', $email);
        return $this->db->execute();
    }
}
