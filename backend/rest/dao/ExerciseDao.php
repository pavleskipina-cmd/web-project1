<?php
require_once __DIR__ . '/BaseDao.php';

class ExerciseDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('exercises', [
            'workout_id',
            'name',
            'muscle_group',
            'default_sets',
            'default_reps'
        ]);
    }

    public function get_by_workout_id($workout_id)
    {
        return $this->query(
            'SELECT * FROM exercises WHERE workout_id = :workout_id ORDER BY id',
            ['workout_id' => $workout_id]
        );
    }
}
