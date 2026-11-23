<?php
require_once __DIR__ . '/../dao/ReviewDao.php';
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../dao/WorkoutDao.php';
require_once __DIR__ . '/BaseService.php';

class ReviewService extends BaseService
{
    protected $user_dao;
    protected $workout_dao;

    public function __construct($dao = null, $user_dao = null, $workout_dao = null)
    {
        parent::__construct($dao ?: new ReviewDao());
        $this->user_dao = $user_dao ?: new UserDao();
        $this->workout_dao = $workout_dao ?: new WorkoutDao();
    }

    protected function validate($review, $id = null)
    {
        Validator::required($review, ['user_id', 'workout_id', 'rating']);
        Validator::integer($review['user_id'], 'user_id', 1);
        Validator::integer($review['workout_id'], 'workout_id', 1);
        Validator::integer($review['rating'], 'rating', 1, 5);

        if (isset($review['comment']) && $review['comment'] !== null) {
            Validator::length($review['comment'], 'comment', 0, 65535);
        }

        $user = $this->user_dao->get_by_id($review['user_id']);
        if (!$user) {
            throw new NotFoundException("User not found.");
        }

        $workout = $this->workout_dao->get_by_id($review['workout_id']);
        if (!$workout) {
            throw new NotFoundException("Workout not found.");
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
