<?php

namespace App\Http\Controllers\Db;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Exception;

// Сохраняем в БД сделки.
class LeadController extends Controller {
    static public function leadSave($lead) {
        try {
            Lead::query()->create([
                'id' => $lead['id'],
                'name' => $lead['name'],
                'price' => $lead['price'],
                'responsible_user_id' => $lead['responsible_user_id'],
                'group_id' => $lead['group_id'],
                'status_id' => $lead['status_id'],
                'pipeline_id' => $lead['pipeline_id'],
                'loss_reason_id' => $lead['loss_reason_id'],
                'createdBy' => $lead['created_by'],
                'updatedBy' => $lead['updated_by'],
                'closedAt' => $lead['closed_at'],
                'createdAt' => $lead['created_at'],
                'updatedAt' => $lead['updated_at'],
                'closest_task_at' => $lead['closest_task_at'],
                'is_deleted' => $lead['is_deleted'],
                'score' => $lead['score'],
                'account_id' => $lead['account_id'],
                'company_id' => $lead['company']['id'] ?? null,
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
