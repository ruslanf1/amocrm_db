<?php

namespace App\Http\Controllers\Db;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Exception;

// Сохраняем компании в БД. Из доп полей забираем номер телефона.
class CompanyController extends Controller {
    static public function companySave($lead, $apiClient) {
        try {
            $company = $apiClient->companies()->getOne($lead['company']['id']);
            $phone = $company->getCustomFieldsValues()->getBy('fieldCode', 'PHONE');
            if ($phone) {
                $phone = $phone->getValues()->toArray();
            }
            $companyArray = $company->toArray();
            Company::query()->firstOrCreate([
                'id' => $companyArray['id'],
                'name' => $companyArray['name'],
                'phone' => $phone[0]['value'] ?? null,
                'responsible_user_id' => $companyArray['responsible_user_id'],
                'group_id' => $companyArray['group_id'],
                'createdBy' => $companyArray['created_by'],
                'updatedBy' => $companyArray['updated_by'],
                'createdAt' => $companyArray['created_at'],
                'updatedAt' => $companyArray['updated_at'],
                'closest_task_at' => $companyArray['closest_task_at'],
                'is_deleted' => $companyArray['is_deleted'] ?? null,
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
