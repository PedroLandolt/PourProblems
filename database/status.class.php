<?php
declare(strict_types=1);

class Status
{
    public int $id;
    public string $stat;

    public function __construct(int $id, string $stat)
    {
        $this->id = $id;
        $this->stat = $stat;
    }

    static function getStatus(PDO $db, int $id): Status
    {
        $stmt = $db->prepare('SELECT id, stat FROM Status WHERE id = ?');

        $stmt->execute(array($id));
        $status = $stmt->fetch();

        return new Status($status['id'], $status['stat']);
    }

    static function getAll_Status(PDO $db): array
    {
        $stmt = $db->prepare('SELECT * FROM Status');

        $stmt->execute(array());

        $all_status = [];

        while ($status = $stmt->fetch()) {
            $all_status[] = new Status(
                intval($status['id']),
                strval($status['stat'])
            );
        }
        return $all_status;
    }

    static function getStatus_from_name(PDO $db, string $stat): Status
    {
        $stmt = $db->prepare('SELECT * FROM Status WHERE stat = ?');

        $stmt->execute(array($stat));
        $status = $stmt->fetch();

        return new Status($status['id'], $status['stat']);
    }
}
?>