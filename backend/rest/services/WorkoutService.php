<?php
require_once __DIR__ . '/../dao/WorkoutDao.php';
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../dao/ExerciseDao.php';
require_once __DIR__ . '/../dao/ReviewDao.php';
require_once __DIR__ . '/BaseService.php';

class WorkoutService extends BaseService
{
    protected $user_dao;
    protected $exercise_dao;
    protected $review_dao;

    public function __construct($dao = null, $user_dao = null, $exercise_dao = null, $review_dao = null)
    {
        parent::__construct($dao ?: new WorkoutDao());
        $this->user_dao = $user_dao ?: new UserDao();
        $this->exercise_dao = $exercise_dao ?: new ExerciseDao();
        $this->review_dao = $review_dao ?: new ReviewDao();
    }

    protected function validate($workout, $id = null)
    {
        Validator::required($workout, ['user_id', 'title', 'category']);
        Validator::integer($workout['user_id'], 'user_id', 1);
        Validator::length($workout['title'], 'title', 1, 150);
        Validator::length($workout['category'], 'category', 1, 80);

        if (isset($workout['description']) && $workout['description'] !== null) {
            Validator::length($workout['description'], 'description', 0, 65535);
        }

        $user = $this->user_dao->get_by_id($workout['user_id']);
        if (!$user) {
            throw new NotFoundException("User not found.");
        }
    }

    public function get_by_user_id($user_id)
    {
        Validator::integer($user_id, 'user_id', 1);

        $user = $this->user_dao->get_by_id($user_id);
        if (!$user) {
            throw new NotFoundException("User not found.");
        }

        return $this->dao->get_by_user_id($user_id);
    }

    public function delete($id)
    {
        $this->get_by_id($id);

        $exercises = $this->exercise_dao->get_by_workout_id($id);
        $reviews = $this->review_dao->get_by_workout_id($id);

        $dependent_types = [];
        if (!empty($exercises)) {
            $dependent_types[] = 'exercises';
        }
        if (!empty($reviews)) {
            $dependent_types[] = 'reviews';
        }

        if (!empty($dependent_types)) {
            throw new ValidationException(
                'Workout cannot be deleted because dependent ' . implode(' and ', $dependent_types)
                . ' must be removed first; deletion is restricted.'
            );
        }

        $this->dao->delete($id);
    }
}
