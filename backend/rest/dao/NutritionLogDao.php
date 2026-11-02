<?php
require_once __DIR__ . '/BaseDao.php';

class NutritionLogDao extends BaseDao
{
    public function __construct()
    {
        parent::__construct('nutrition_logs', [
            'user_id',
            'meal_type',
            'calories',
            'protein_grams',
            'date'
        ]);
    }

    public function get_by_user_id($user_id)
    {
        return $this->query(
            'SELECT * FROM nutrition_logs WHERE user_id = :user_id ORDER BY date DESC, id DESC',
            ['user_id' => $user_id]
        );
    }

    public function get_by_user_and_date($user_id, $date)
    {
        return $this->query(
            'SELECT * FROM nutrition_logs
             WHERE user_id = :user_id AND date = :date
             ORDER BY id',
            [
                'user_id' => $user_id,
                'date' => $date
            ]
        );
    }
}
