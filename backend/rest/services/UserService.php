<?php
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/../dao/WorkoutDao.php';
require_once __DIR__ . '/../dao/NutritionLogDao.php';
require_once __DIR__ . '/../dao/ReviewDao.php';
require_once __DIR__ . '/BaseService.php';

class UserService extends BaseService
{
    protected $workout_dao;
    protected $nutrition_log_dao;
    protected $review_dao;

    public function __construct($dao = null, $workout_dao = null, $nutrition_log_dao = null, $review_dao = null)
    {
        parent::__construct($dao ?: new UserDao());
        $this->workout_dao = $workout_dao ?: new WorkoutDao();
        $this->nutrition_log_dao = $nutrition_log_dao ?: new NutritionLogDao();
        $this->review_dao = $review_dao ?: new ReviewDao();
    }

    protected function validate($user, $id = null)
    {
        Validator::required($user, ['name', 'email', 'role']);
        Validator::length($user['name'], 'name', 1, 100);

        $email = strtolower(trim((string) $user['email']));
        $user['email'] = $email;
        Validator::email($email);
        Validator::length($email, 'email', 1, 255);
        Validator::one_of($user['role'], 'role', ['admin', 'user']);

        $existing = $this->dao->get_by_email($email);
        if ($existing && (int) $existing['id'] !== (int) $id) {
            throw new ValidationException("Email '$email' is already in use.");
        }
    }

    public function add($user)
    {
        if (!isset($user['role']) || trim((string) $user['role']) === '') {
            $user['role'] = 'user';
        }
        if (isset($user['email'])) {
            $user['email'] = strtolower(trim((string) $user['email']));
        }

        Validator::required($user, ['password']);
        Validator::password($user['password']);

        $user['password_hash'] = password_hash($user['password'], PASSWORD_BCRYPT);
        unset($user['password']);

        return parent::add($user);
    }

    public function update($user, $id)
    {
        $existing = $this->get_by_id($id);
        $user = array_merge($existing, $user);
        unset($user['created_at']);

        if (isset($user['email'])) {
            $user['email'] = strtolower(trim((string) $user['email']));
        }
        return parent::update($user, $id);
    }

    public function delete($id)
    {
        $this->get_by_id($id);

        $dependent_types = [];
        if (!empty($this->workout_dao->get_by_user_id($id))) {
            $dependent_types[] = 'workouts';
        }
        if (!empty($this->nutrition_log_dao->get_by_user_id($id))) {
            $dependent_types[] = 'nutrition logs';
        }
        if (!empty($this->review_dao->get_by_user_id($id))) {
            $dependent_types[] = 'reviews';
        }

        if (!empty($dependent_types)) {
            throw new ValidationException(
                'User cannot be deleted because dependent ' . implode(', ', $dependent_types)
                . ' must be removed first; deletion is restricted.'
            );
        }

        $this->dao->delete($id);
    }
}
