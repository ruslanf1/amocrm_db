<?php

namespace App\Http\Controllers\Amo;

use AmoCRM\Client\AmoCRMApiClient;
use App\Http\Controllers\Controller;
use App\Models\Access;
use Exception;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\AccessTokenInterface;

// Получаем токен доступа и обьект библиотеки.
class GetController extends Controller {
    static public function getApi() {
        try {
            $apiClient = new AmoCRMApiClient(
                config('services.amo.client_id'),
                config('services.amo.client_secret'),
                config('services.amo.client_redirect'),
            );

            $response = Access::first();
            $accessToken = new AccessToken([
                'access_token' => $response->access_token,
                'refresh_token' => $response->refresh_token,
                'expires' => $response->expires,
                'baseDomain' => config('services.amo.sub_domain'),
            ]);

            $apiClient->setAccessToken($accessToken)
                ->setAccountBaseDomain($accessToken->getValues()['baseDomain'])
                ->onAccessTokenRefresh(
                    function (AccessTokenInterface $accessToken) {
                        Access::first()->update([
                                'access_token' => $accessToken->getToken(),
                                'refresh_token' => $accessToken->getRefreshToken(),
                                'expires' => $accessToken->getExpires()
                            ]
                        );
                    }
                );
            return $apiClient;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
