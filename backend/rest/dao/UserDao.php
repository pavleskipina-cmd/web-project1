<?php
require_once __DIR__ . '/BaseDao.php';

class UserDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('users', [
            'name',
            'email',
            'password_hash',
            'role'
        ]);
    }

    public function get_all()
    {
        return $this->query(
            'SELECT id, name, email, role, created_at
             FROM users
             ORDER BY id'
        );
    }

    public function get_by_id($id)
    {
        return $this->query_unique(
            'SELECT id, name, email, role, created_at
             FROM users
             WHERE id = :id',
            ['id' => $id]
        );
    }

    public function get_by_email($email)
    {
        return $this->query_unique(
            'SELECT id, name, email, role, created_at
             FROM users
             WHERE email = :email',
            ['email' => $email]
        );
    }

    public function get_authentication_record_by_email($email)
    {
        return $this->query_unique(
            'SELECT id, email, password_hash, role
             FROM users
             WHERE email = :email',
            ['email' => $email]
        );
    }
}
