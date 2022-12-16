<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Amo\GetController;
use App\Http\Controllers\Db\CompanyController;
use App\Http\Controllers\Db\ContactController;
use App\Http\Controllers\Db\LeadController;
use Exception;
use Illuminate\Support\Facades\DB;

// Приложение выгружает в БД сделки и связанные с ними сущности: контакты, компании. Создается 3 таблицы,
// между ними рализованы связи.
class IndexController extends Controller {
    public function saveLeads() {
        try {
            DB::beginTransaction();
            $apiClient = GetController::getApi();

            $leads = $apiClient->leads()->get(null, ['contacts'])->toArray();
            foreach ($leads as $lead) {
                if ($lead) {
                    LeadController::leadSave($lead);
                    if (isset($lead['company'])) {
                        CompanyController::companySave($lead, $apiClient);
                    }
                    foreach ($lead['contacts'] as $item) {
                        if ($item) {
                            ContactController::contactSave($lead, $item, $apiClient);
                        }
                    }
                }
            }
            DB::commit();
        } catch (Exception $e) {
            Db::rollBack();
            echo $e->getMessage();
        }
    }
}
