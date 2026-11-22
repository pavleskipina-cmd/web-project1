<?php
require_once __DIR__ . '/../dao/ExerciseDao.php';
require_once __DIR__ . '/../dao/WorkoutDao.php';
require_once __DIR__ . '/BaseService.php';

class ExerciseService extends BaseService
{
    protected $workout_dao;

    public function __construct($dao = null, $workout_dao = null)
    {
        parent::__construct($dao ?: new ExerciseDao());
        $this->workout_dao = $workout_dao ?: new WorkoutDao();
    }

    protected function normalize($exercise)
    {
        if (isset($exercise['sets']) && !array_key_exists('default_sets', $exercise)) {
            $exercise['default_sets'] = $exercise['sets'];
        }
        if (isset($exercise['reps']) && !array_key_exists('default_reps', $exercise)) {
            $exercise['default_reps'] = $exercise['reps'];
        }
        unset($exercise['sets'], $exercise['reps']);
        return $exercise;
    }

    protected function validate($exercise, $id = null)
    {
        $exercise = $this->normalize($exercise);

        Validator::required($exercise, [
            'workout_id',
            'name',
            'muscle_group',
            'default_sets',
            'default_reps'
        ]);
        Validator::integer($exercise['workout_id'], 'workout_id', 1);
        Validator::length($exercise['name'], 'name', 1, 150);
        Validator::length($exercise['muscle_group'], 'muscle_group', 1, 80);
        Validator::integer($exercise['default_sets'], 'sets', 1);
        Validator::integer($exercise['default_reps'], 'reps', 1);

        $workout = $this->workout_dao->get_by_id($exercise['workout_id']);
        if (!$workout) {
            throw new NotFoundException("Workout not found.");
        }
    }

    public function add($exercise)
    {
        return parent::add($this->normalize($exercise));
    }

    public function update($exercise, $id)
    {
        return parent::update($this->normalize($exercise), $id);
    }

    public function get_by_workout_id($workout_id)
    {
        Validator::integer($workout_id, 'workout_id', 1);

        $workout = $this->workout_dao->get_by_id($workout_id);
        if (!$workout) {
            throw new NotFoundException("Workout not found.");
        }

        return $this->dao->get_by_workout_id($workout_id);
    }
}
