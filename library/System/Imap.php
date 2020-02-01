<?php

/**
 * Klasse zur Verbindung via IMAP und E-Mail Funktionen
 *
 * @author    Werner Pallentin <werner.pallentin@outlook.de>
 * @package   Module
 */
class Imap
{

    private static $instance;
    private $imapbox;
    private $mailbox;

    public function __construct()
    {

    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self ();
        }

        return self::$instance;
    }

    public function deleteMail($no)
    {
        imap_delete($this->imapbox, $no);
        imap_expunge($this->imapbox);
    }

    public function checkMailbox($host, $user, $pass)
    {
        $this->openMailbox($host, $user, $pass);
        $this->mailbox = imap_check($this->imapbox);

        if ($this->mailbox->Nmsgs >= 1) {
            return $this->readMails();
        }
    }

    private function openMailbox($host, $user, $pass)
    {
        $mbox = '{' . $host . ':143/notls}';
        $this->imapbox = imap_open($mbox . 'INBOX', $user, $pass);
    }

    public function readMails()
    {
        $aData = array();
        $message = array();

        $overview = imap_fetch_overview($this->imapbox, "1:" . $this->mailbox->Nmsgs, 0);
        $size = sizeof($overview);

        for ($i = $size - 1; $i >= 0; $i--) {
            if ($overview [$i]->seen == 0) {
                $message [$i] ['email'] = explode('<', $overview [$i]->from);
                if (count($message [$i] ['email']) > 0) {
                    $message [$i] ['email'] = str_replace('>', '', $message [$i] ['email'] ['1']);
                }

                $message [$i] ['no'] = $overview [$i]->msgno;
                $message [$i] ['to'] = $overview [$i]->to;
                $message [$i] ['size'] = round(($overview [$i]->size / 1024), 2);
                $message [$i] ['date'] = $overview [$i]->date;
                $message [$i] ['subject'] = imap_utf8($overview [$i]->subject);
                $message [$i] ['seen'] = $overview [$i]->seen;
                $message [$i] ['nachricht'] = imap_fetchbody($this->imapbox, $overview [$i]->msgno, 1);
                $message [$i] ['nachricht'] = quoted_printable_decode($message [$i] ['nachricht']);
                $message [$i] ['nachricht'] = utf8_encode($message [$i] ['nachricht']);
                $message [$i] ['nachricht'] = nl2br($message [$i] ['nachricht']);
            }
        }
        return array_values($message);
    }

}
