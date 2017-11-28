<?php
namespace Models\Stasich;

class SupBot
{
    private $pdo;
    private $token;

    public function __construct()
    {
        $config = ClassConfig::getConfig();
        $this->token = $config['token'];
        try {
            $this->pdo = new \PDO(
                'mysql:host=localhost;dbname=' . $config['dbname'] . ';charset=' . $config['charset'],
                $config['user'],
                $config['pass']
            );
        } catch (\Exception $e) {
            echo 'Нет соединения с базой данных.';
        }
    }

    public function addDataToDB($json)
    {
        $webhookData = json_decode($json, true);
        //echo "<pre>"; print_r($webhookData); echo "</pre>";
        extract($this->parseWebhook($webhookData));

        if (!$this->isClientInDB($clientId)) {
            $this->addClientInDB($clientId);
        }
    }

    private function isClientInDB($clientId)
    {
        return true;
    }

    private function addClientInDB($clientId)
    {
        return true;
    }

    private function parseWebhook($webhookData)
    {
        $resultArr['clientId'] = $webhookData['message']['from']['id'];
        $resultArr['firstName'] = $webhookData['message']['from']['first_name'];
        $resultArr['lastName'] = (isset($webhookData['message']['from']['last_name'])) ?
            $webhookData['message']['from']['last_name'] : null;
        $resultArr['avatar'] = $this->setAvatar($resultArr['clientId']);
        $resultArr['text'] = $webhookData['message']['text'];
        $resultArr['chatId'] = $webhookData['message']['from']['id'];
        $resultArr['time'] = $webhookData['message']['date'];
        $resultArr['messageId'] = $webhookData['message']['message_id'];

        return $resultArr;
    }

    private function setAvatar($clientId)
    {
        return '/avatars/';
    }
}