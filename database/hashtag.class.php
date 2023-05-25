<?php
declare(strict_types=1);

class Hashtag
{
    public int $id;
    public string $name;
    public int $ticket_id;

    public function __construct(int $id, string $name, int $ticket_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->ticket_id = $ticket_id;
    }

    static function getHashtag(PDO $db, int $id): Hashtag
    {
        $stmt = $db->prepare('SELECT * FROM Hashtag WHERE id = ?');

        $stmt->execute(array($id));
        $chat = $stmt->fetch();

        return new Hashtag($chat['id'], $chat['name'], $chat['ticket_id']);
    }

    static function getHashtags_from_ticket(PDO $db, int $ticket_id): array
    {
        $stmt = $db->prepare('SELECT * FROM Hashtag WHERE ticket_id = ?');

        $stmt->execute(array($ticket_id));

        $hashtags = [];

        while ($hashtag = $stmt->fetch()) {
            $hashtags[] = new Hashtag(
                $hashtag['id'],
                strval($hashtag['name']),
                $hashtag['ticket_id']
            );
        }
        return $hashtags;
    }

    static function getHashtags(PDO $db): array
    {
        $stmt = $db->prepare('SELECT * FROM Hashtag');
        $stmt->execute();

        $hashtags = array();
        while ($hashtag = $stmt->fetch()) {
            $hashtags[] = new Hashtag(
                $hashtag['id'],
                $hashtag['name'],
                $hashtag['ticket_id']
            );
        }

        return $hashtags;
    }
}
?>