<?php
require_once __DIR__ . '/BaseDao.php';

class WorkoutDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('workouts', [
            'user_id',
            'title',
            'description',
            'category'
        ]);
    }

    public function get_by_user_id($user_id)
    {
        return $this->query(
            'SELECT * FROM workouts WHERE user_id = :user_id ORDER BY id',
            ['user_id' => $user_id]
        );
    }
}
