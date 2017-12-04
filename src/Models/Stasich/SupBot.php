<?php
namespace Models\Stasich;

class SupBot
{
    private $pdo;
    private $token;
    private $webhookArr;

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
            die();
        }
    }

    public function addDataToDB($webhookJson)
    {
        $this->webhookArr = $this->parseWebhook($webhookJson);

        if (!$this->isClientInDB($this->webhookArr['client_id'])) {
            $this->addClientToDB();
        }
    }

    private function isClientInDB($clientId)
    {
        $query = 'select client_id from clients where client_id = :client_id';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
           ':client_id' => $clientId
        ]);
        if ($stmt->fetch() === false)
            return false;
        return true;
    }

    private function addClientToDB()
    {
        $this->webhookArr['avatar'] = $this->getAvatarFromApi();

        $query = "INSERT INTO clients values (
                    :client_id,
                    :first_name,
                    :last_name,
                    :avatar,
                    :favorite
        )";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':client_id', $this->webhookArr['client_id']);
        $stmt->bindValue(':first_name', $this->webhookArr['first_name']);
        $stmt->bindValue(
            ':last_name',
            (isset($this->webhookArr['last_name'])) ? $this->webhookArr['last_name'] : null
        );
        $stmt->bindValue(':avatar', $this->webhookArr['avatar']);
        $stmt->bindValue(':favorite', '0');
        if (!$stmt->execute())
            return false;
        return true;
    }

    private function parseWebhook($webhookJson)
    {
        $webhookData = json_decode($webhookJson, true);
        $resultArr['client_id'] = $webhookData['message']['from']['id'];
        $resultArr['first_name'] = $webhookData['message']['from']['first_name'];
        $resultArr['last_name'] = (isset($webhookData['message']['from']['last_name'])) ?
            $webhookData['message']['from']['last_name'] : null;
        $resultArr['text'] = $webhookData['message']['text'];
        $resultArr['chat_id'] = $webhookData['message']['from']['id'];
        $resultArr['time'] = $webhookData['message']['date'];
        $resultArr['message_id'] = $webhookData['message']['message_id'];

        return $resultArr;
    }

    private function getAvatarFromApi()
    {
        $jsonOfPhoto = file_get_contents(
            'https://api.telegram.org'.
            '/bot' . $this->token .
            '/getUserProfilePhotos' .
            '?user_id=' . $this->webhookArr['client_id']
        );
        $listOfPhoto = json_decode($jsonOfPhoto, true);

        if ($listOfPhoto['ok'] === false)
            return null;
        if ($listOfPhoto['result']['total_count'] == 0)
            return null;

        $jsonPhotoInfo = file_get_contents(
            'https://api.telegram.org'.
            '/bot' . $this->token .
            '/getFILE'.
            '?file_id=' . $listOfPhoto['result']['photos'][0][0]['file_id']
        );
        $photoInfo = json_decode($jsonPhotoInfo, true);
        $photoPath = $photoInfo['result']['file_path'];

        $fileName = $this->webhookArr['client_id'] . '.jpg';
        $file = fopen('avatars/'.$fileName, 'w');

        $ch = curl_init();
        curl_setopt(
            $ch,
            CURLOPT_URL,
            'https://api.telegram.org'.
            '/file'.
            '/bot'. $this->token .
            '/' . $photoPath
        );
        curl_setopt($ch, CURLOPT_FILE, $file);
        curl_exec($ch);
        curl_close($ch);

        fclose($file);

        return $fileName;
    }
}