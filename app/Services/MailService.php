<?php

namespace App\Services;

use CodeIgniter\Email\Email;
use Config\Email as EmailConfig;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;

class MailService
{
    protected EmailConfig $config;

    public function __construct(?EmailConfig $config = null)
    {
        $this->config = $config ?? config('Email');
    }

    /**
     * Envoie un e-mail via CI4 Email, avec repli PHPMailer si nécessaire.
     *
     * @param list<string>|string $to
     * @param list<string>|string|null $cc
     * @param list<string>|string|null $bcc
     */
    public function send(
        array|string $to,
        string $subject,
        string $body,
        bool $isHtml = true,
        array|string|null $cc = null,
        array|string|null $bcc = null,
        ?string $replyTo = null,
    ): bool {
        $to = is_array($to) ? $to : [$to];

        if ($this->sendWithCiEmail($to, $subject, $body, $isHtml, $cc, $bcc, $replyTo)) {
            return true;
        }

        return $this->sendWithPhpMailer($to, $subject, $body, $isHtml, $cc, $bcc, $replyTo);
    }

    /**
     * @param list<string> $to
     */
    protected function sendWithCiEmail(
        array $to,
        string $subject,
        string $body,
        bool $isHtml,
        array|string|null $cc,
        array|string|null $bcc,
        ?string $replyTo,
    ): bool {
        try {
            /** @var Email $email */
            $email = service('email');
            $email->clear(true);
            $email->setTo($to);
            $email->setFrom($this->fromEmail(), $this->fromName());
            $email->setSubject($subject);
            $email->setMessage($body);
            $email->setMailType($isHtml ? 'html' : 'text');

            if ($cc !== null) {
                $email->setCC($cc);
            }
            if ($bcc !== null) {
                $email->setBCC($bcc);
            }
            if ($replyTo !== null) {
                $email->setReplyTo($replyTo);
            }

            return $email->send(false);
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * @param list<string> $to
     */
    protected function sendWithPhpMailer(
        array $to,
        string $subject,
        string $body,
        bool $isHtml,
        array|string|null $cc,
        array|string|null $bcc,
        ?string $replyTo,
    ): bool {
        try {
            $mail = new PHPMailer(true);
            $mail->CharSet = 'UTF-8';
            $mail->isHTML($isHtml);

            if ($this->config->protocol === 'smtp' && $this->config->SMTPHost !== '') {
                $mail->isSMTP();
                $mail->Host       = $this->config->SMTPHost;
                $mail->Port       = $this->config->SMTPPort;
                $mail->SMTPAuth   = $this->config->SMTPUser !== '';
                $mail->Username   = $this->config->SMTPUser;
                $mail->Password   = $this->config->SMTPPass;
                $mail->SMTPSecure = $this->config->SMTPCrypto ?: PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                $mail->isMail();
            }

            $mail->setFrom($this->fromEmail(), $this->fromName());

            foreach ($to as $address) {
                $mail->addAddress($address);
            }

            if ($cc !== null) {
                foreach ((array) $cc as $address) {
                    $mail->addCC($address);
                }
            }

            if ($bcc !== null) {
                foreach ((array) $bcc as $address) {
                    $mail->addBCC($address);
                }
            }

            if ($replyTo !== null) {
                $mail->addReplyTo($replyTo);
            }

            $mail->Subject = $subject;
            $mail->Body    = $body;
            if ($isHtml) {
                $mail->AltBody = strip_tags($body);
            }

            return $mail->send();
        } catch (PHPMailerException|\Throwable) {
            return false;
        }
    }

    protected function fromEmail(): string
    {
        return $this->config->fromEmail
            ?: (string) env('SMTP_FROM_EMAIL', 'noreply@dbdigitalagency.com');
    }

    protected function fromName(): string
    {
        return $this->config->fromName
            ?: (string) env('SMTP_FROM_NAME', 'DB Digital Agency');
    }
}
