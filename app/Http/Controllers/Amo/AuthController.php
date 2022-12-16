<?php

namespace App\Http\Controllers\Amo;

use AmoCRM\Client\AmoCRMApiClient;
use App\Http\Controllers\Controller;
use App\Models\Access;
use Exception;

// Сохраняем в БД токены доступа.
class AuthController extends Controller {
    protected function saveTokens() {
        try {
            $apiClient = new AmoCRMApiClient(
                config('services.amo.client_id'),
                config('services.amo.client_secret'),
                config('services.amo.client_redirect')
            );

            $apiClient->setAccountBaseDomain(config('services.amo.sub_domain'));
            $response = $apiClient->getOAuthClient()->getAccessTokenByCode(config('services.amo.client_code'));

            if (!$response->hasExpired()) {
                Access::query()->create([
                    'access_token' => $response->getToken(),
                    'refresh_token' => $response->getRefreshToken(),
                    'expires' => $response->getExpires()
                ]);
            } else {
                return throw new Exception('Код доступа не сохранен', 404);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
