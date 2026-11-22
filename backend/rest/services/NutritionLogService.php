<?php
require_once __DIR__ . '/../dao/NutritionLogDao.php';
require_once __DIR__ . '/../dao/UserDao.php';
require_once __DIR__ . '/BaseService.php';

class NutritionLogService extends BaseService
{
    protected $user_dao;

    public function __construct($dao = null, $user_dao = null)
    {
        parent::__construct($dao ?: new NutritionLogDao());
        $this->user_dao = $user_dao ?: new UserDao();
    }

    protected function validate($log, $id = null)
    {
        Validator::required($log, [
            'user_id',
            'meal_type',
            'calories',
            'protein_grams',
            'date'
        ]);
        Validator::integer($log['user_id'], 'user_id', 1);
        Validator::length($log['meal_type'], 'meal_type', 1, 50);
        Validator::date($log['date'], 'date');
        Validator::integer($log['calories'], 'calories', 0);

        if (!is_numeric($log['protein_grams']) || (float) $log['protein_grams'] < 0) {
            throw new ValidationException("Field 'protein_grams' must be a non-negative number.");
        }

        $user = $this->user_dao->get_by_id($log['user_id']);
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

    public function get_by_user_and_date($user_id, $date)
    {
        Validator::integer($user_id, 'user_id', 1);
        Validator::date($date, 'date');

        $user = $this->user_dao->get_by_id($user_id);
        if (!$user) {
            throw new NotFoundException("User not found.");
        }

        return $this->dao->get_by_user_and_date($user_id, $date);
    }
}
