<?php

namespace App\Services\Mailer;

use GuzzleHttp\Client;

class GmailApiMailer
{
    protected Client $http;

    public function __construct()
    {
        $this->http = new Client(['timeout' => 10]);
    }

    protected function parseDsn(): array
    {
        $dsn = env('MAIL_URL', '');
        $cfg = [
            'user' => env('GOOGLE_GMAIL_USER'),
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'refresh_token' => env('GOOGLE_REFRESH_TOKEN'),
        ];
        if (is_string($dsn) && str_starts_with($dsn, 'gmail+api://')) {
            $parts = parse_url($dsn);
            if (!empty($parts['user'])) $cfg['user'] = $parts['user'];
            if (!empty($parts['query'])) {
                parse_str($parts['query'], $q);
                foreach (['client_id','client_secret','refresh_token'] as $k) {
                    if (!empty($q[$k])) $cfg[$k] = $q[$k];
                }
            }
        }
        return $cfg;
    }

    protected function fetchAccessToken(array $cfg): string
    {
        $resp = $this->http->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'client_id' => $cfg['client_id'],
                'client_secret' => $cfg['client_secret'],
                'refresh_token' => $cfg['refresh_token'],
                'grant_type' => 'refresh_token',
            ],
        ]);
        $data = json_decode((string) $resp->getBody(), true);
        return (string) ($data['access_token'] ?? '');
    }

    protected function base64url(string $raw): string
    {
        return rtrim(strtr(base64_encode($raw), '+/', '-_'), '=');
    }

    public function send(array $payload): void
    {
        $cfg = $this->parseDsn();
        $fromAddress = $payload['from']['address'] ?? env('MAIL_FROM_ADDRESS');
        $fromName = $payload['from']['name'] ?? env('MAIL_FROM_NAME');
        $from = $fromName ? sprintf('%s <%s>', $fromName, $fromAddress) : $fromAddress;

        $to = $payload['to'] ?? [];
        if (!is_array($to)) $to = [$to];

        $subject = (string) ($payload['subject'] ?? '(no subject)');
        $bodyHtml = $payload['body_html'] ?? null;
        $bodyText = $payload['body_text'] ?? null;

        $accessToken = $this->fetchAccessToken($cfg);

        foreach ($to as $addr) {
            $headers = [
                'To' => $addr,
                'From' => $from,
                'Subject' => '=?UTF-8?B?'.base64_encode($subject).'?=',
                'MIME-Version' => '1.0',
            ];

            if ($bodyHtml) {
                $headers['Content-Type'] = 'text/html; charset=UTF-8';
                $mime = $this->headersToString($headers)."\r\n".($bodyHtml);
            } else {
                $headers['Content-Type'] = 'text/plain; charset=UTF-8';
                $mime = $this->headersToString($headers)."\r\n".($bodyText ?? '');
            }

            $raw = $this->base64url($mime);

            $this->http->post('https://gmail.googleapis.com/gmail/v1/users/me/messages/send', [
                'headers' => [
                    'Authorization' => 'Bearer '.$accessToken,
                    'Content-Type' => 'application/json',
                ],
                'json' => ['raw' => $raw],
            ]);
        }
    }

    protected function headersToString(array $headers): string
    {
        $lines = [];
        foreach ($headers as $k => $v) {
            $lines[] = $k.': '.$v;
        }
        return implode("\r\n", $lines)."\r\n\r\n";
    }
}

