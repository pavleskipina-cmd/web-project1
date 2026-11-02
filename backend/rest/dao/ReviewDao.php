<?php
require_once __DIR__ . '/BaseDao.php';

class ReviewDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('reviews', [
            'user_id',
            'workout_id',
            'rating',
            'comment'
        ]);
    }

    public function get_by_user_id($user_id)
    {
        return $this->query(
            'SELECT * FROM reviews WHERE user_id = :user_id ORDER BY id',
            ['user_id' => $user_id]
        );
    }

    public function get_by_workout_id($workout_id)
    {
        return $this->query(
            'SELECT * FROM reviews WHERE workout_id = :workout_id ORDER BY id',
            ['workout_id' => $workout_id]
        );
    }
}
