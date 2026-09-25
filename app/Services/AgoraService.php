<?php

namespace App\Services;

use App\Models\LiveSession;
use App\Models\User;
use Peterujah\Agora\Agora;
use Peterujah\Agora\Builders\RtcToken;
use Peterujah\Agora\Roles;
use Peterujah\Agora\User as AgoraUser;

class AgoraService
{
    /**
     * Get the configured Agora App ID from environment/configuration.
     */
    public function getAppId(): ?string
    {
        return config('services.agora.app_id');
    }

    /**
     * Get the configured Agora App Certificate (server-side only, NEVER exposed client-side).
     */
    public function getAppCertificate(): ?string
    {
        return config('services.agora.app_certificate');
    }

    /**
     * Check whether an App Certificate is configured.
     */
    public function isCertificateConfigured(): bool
    {
        $cert = $this->getAppCertificate();

        return ! empty($cert);
    }

    /**
     * Generate an Agora RTC connection payload (token, channel, app id, uid).
     *
     * @return array{
     *     token: ?string,
     *     app_id: ?string,
     *     channel_name: string,
     *     uid: int,
     *     role: string,
     *     is_host: bool,
     *     testing_mode: bool,
     *     expires_at: ?int
     * }
     */
    public function generateTokenForSession(LiveSession $session, User $user): array
    {
        $appId = $this->getAppId();
        $certificate = $this->getAppCertificate();
        $isHost = (int) $session->host_id === (int) $user->id;

        // Ensure session has an agora_channel_name
        $channelName = $session->agora_channel_name;
        if (empty($channelName)) {
            $channelName = LiveSession::generateChannelName($session->title);
            $session->forceFill(['agora_channel_name' => $channelName])->saveQuietly();
        }

        $uid = (int) $user->id;

        // Check if App Certificate is present
        if (empty($certificate)) {
            /*
             * =====================================================================
             * SECURITY NOTICE — INSECURE AGORA TESTING MODE
             * =====================================================================
             * AGORA_APP_CERTIFICATE is not configured in .env.
             * The application is running in Agora testing mode (App ID only, no token
             * required to join a channel).
             *
             * WARNING: This mode is INSECURE for production. Anyone with the App ID
             * and channel name could join any live session's channel without
             * server authorization.
             *
             * An App Certificate must be generated in the Agora console and set as
             * AGORA_APP_CERTIFICATE in .env before deploying to real users.
             * =====================================================================
             */
            return [
                'token' => null,
                'app_id' => $appId,
                'channel_name' => $channelName,
                'uid' => $uid,
                'role' => $isHost ? 'host' : 'attendee',
                'is_host' => $isHost,
                'testing_mode' => true,
                'expires_at' => null,
            ];
        }

        // Token expiration: session duration_minutes + 15 minutes buffer
        $expireSeconds = max(15, (int) $session->duration_minutes + 15) * 60;
        $expireTimestamp = time() + $expireSeconds;

        $client = new Agora($appId, $certificate);
        $client->setExpiration($expireTimestamp);

        $agoraUser = new AgoraUser($uid);
        $agoraUser->setChannel($channelName);
        $agoraUser->setRole(Roles::RTC_PUBLISHER);
        $agoraUser->setPrivilegeExpire($expireTimestamp);

        $token = RtcToken::buildTokenWithUid($client, $agoraUser);

        return [
            'token' => $token,
            'app_id' => $appId,
            'channel_name' => $channelName,
            'uid' => $uid,
            'role' => $isHost ? 'host' : 'attendee',
            'is_host' => $isHost,
            'testing_mode' => false,
            'expires_at' => $expireTimestamp,
        ];
    }
}
