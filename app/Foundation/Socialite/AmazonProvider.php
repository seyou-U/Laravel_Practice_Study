<?php

namespace App\Foundation\Socialite;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

final class AmazonProvider extends AbstractProvider implements ProviderInterface
{
    protected $scopes = [
        'profile'
    ];

    /**
     * OAuth認証を提供しているサービスの認証URLを文字列で記述
     *
     * @param $state
     * @return string
     */
    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase('https://www.amazon.com/ap/oa', $state);
    }

    /**
     * OAuth認証を提供しているサービスのトークン取得URLを文字列で記述
     *
     * @return string
     */
    protected function getTokenUrl()
    {
        return 'https://api.amazon.com/auth/o2/token';
    }

    /**
     * 取得したトークンを利用して、ユーザー情報を取得する
     *
     * @param $token
     * @return array
     */
    protected function getUserByToken($token): array
    {
        $response = $this->getHttpClient()
            ->get('https://api.amazon.com/user/profile', [
                'headers' => [
                    'x-amz-access-token' => $token,
                ]
            ]);
        return json_decode(strval($response->getBody()), true);
    }

    /**
     * getUserByTokenメソッドで取得した配列をUserインスタンスに変換する
     *
     * @param array $user
     * @return User
     */
    protected function mapUserToObject(array $user): User
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['user_id'],
            'nickname' => $user['name'],
            'name' => $user['name'],
            'email' => $user['email'],
            'avatar' => '',
        ]);
    }

    /**
     * POSTフィールドに対し、grant_typeを追加する
     *
     * @param $code
     * @return array
     */
    protected function getTokenFields($code): array
    {
        return parent::getTokenFields($code) + [
            'grant_type' => 'authorization_code'
        ];
    }



}
