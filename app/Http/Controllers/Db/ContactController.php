<?php

namespace App\Http\Controllers\Db;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Contact_Lead;
use Exception;

// Сохраняем в БД контакты. Из доп полей забираем номер телефона и должность.
class ContactController extends Controller {
    static public function contactSave($lead, $item, $apiClient) {
        try {
            $contact = $apiClient->contacts()->getOne($item['id']);
            $phone = $contact->getCustomFieldsValues()->getBy('fieldCode', 'PHONE');
            if ($phone) {
                $phone = $phone->getValues()->toArray();
            }
            $position = $contact->getCustomFieldsValues()->getBy('fieldCode', 'POSITION');
            if ($position) {
                $position = $position->getValues()->toArray();
            }
            $contactArray = $contact->toArray();
            Contact::query()->firstOrCreate([
                'id' => $contactArray['id'],
                'name' => $contactArray['name'],
                'first_name' => $contactArray['first_name'],
                'last_name' => $contactArray['last_name'],
                'phone' => $phone[0]['value'] ?? null,
                'position' => $position[0]['value'] ?? null,
                'responsible_user_id' => $contactArray['responsible_user_id'],
                'group_id' => $contactArray['group_id'],
                'createdBy' => $contactArray['created_by'],
                'updatedBy' => $contactArray['updated_by'],
                'createdAt' => $contactArray['created_at'],
                'updatedAt' => $contactArray['updated_at'],
                'is_deleted' => $contactArray['is_deleted'] ?? null,
                'closest_task_at' => $contactArray['closest_task_at'],
                'account_id' => $contactArray['account_id'],
            ]);
            Contact_Lead::query()->create([
                'contact_id' => $contactArray['id'],
                'lead_id' => $lead['id'],
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
