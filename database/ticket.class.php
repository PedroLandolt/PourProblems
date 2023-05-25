<?php
declare(strict_types=1);

class Ticket
{
    public int $id;
    public string $subject;
    public string $description;
    public string $datetime;
    public string $department;
    public int $status_id;
    public array $files;
    public array $history;


    public function __construct(int $id, string $subject, string $description, string $datetime, string $department, int $status_id, array $files = array(), array $history = array())
    {
        $this->id = $id;
        $this->subject = $subject;
        $this->description = $description;
        $this->datetime = $datetime;
        $this->department = $department;
        $this->status_id = $status_id;
        $this->files = $files;
        $this->history = $history;
    }

    // maybe missing static function getArtistAlbums(PDO $db, int $id) : array
    static function getTicket(PDO $db, int $id): Ticket
    {
        $stmt = $db->prepare('SELECT * FROM Ticket WHERE id = ?');

        $stmt->execute(array($id));
        $ticket = $stmt->fetch();

        // get all files from Ticket_Files table for this ticket
        $stmt = $db->prepare('SELECT * FROM Ticket_Files WHERE ticket_id = ?');
        $stmt->execute(array($id));
        $files = $stmt->fetchAll();

        $stmt = $db->prepare('SELECT * FROM Ticket_History WHERE ticket_id = ?');
        $stmt->execute(array($id));
        $history = $stmt->fetchAll();

        return new Ticket($ticket['id'], $ticket['subject'], $ticket['description'], $ticket['datetime'], $ticket['department'], $ticket['status_id'], $files, $history);
    }

    static function getAllTickets(PDO $db): array
    {
        $stmt = $db->prepare('SELECT * FROM Ticket');

        $stmt->execute();

        $tickets = array();

        while ($ticket = $stmt->fetch()) {
            // get all files from Ticket_Files table for this ticket
            $stmt = $db->prepare('SELECT * FROM Ticket_Files WHERE ticket_id = ?');
            $stmt->execute(array($ticket['id']));
            $files = $stmt->fetchAll();

            $stmt = $db->prepare('SELECT * FROM Ticket_History WHERE ticket_id = ?');
            $stmt->execute(array($ticket['id']));
            $history = $stmt->fetchAll();

            $tickets[] = new Ticket(
                $ticket['id'],
                strval($ticket['subject']),
                strval($ticket['description']),
                strval($ticket['datetime']),
                strval($ticket['department']),
                $ticket['status_id'],
                $files,
                $history
            );
        }
        return $tickets;
    }

    // get last update to the ticket (last datetime entry from Message table)
    static function getLastUpdate(PDO $db, int $id): string
    {
        $stmt = $db->prepare('SELECT datetime FROM Message WHERE ticket_id = ? ORDER BY datetime DESC LIMIT 1');

        $stmt->execute(array($id));
        $last_update = $stmt->fetch();

        if(!$last_update){
            //return the day the ticket was created
            $stmt = $db->prepare('SELECT datetime FROM Ticket WHERE id = ?');

            $stmt->execute(array($id));

            $ticket = $stmt->fetch();

            return $ticket['datetime'];
        }

        return $last_update['datetime'];
    }

    static function getDiffFromLastUpdateAndNow(PDO $db, int $id): string
    {
        $last_update = Ticket::getLastUpdate($db, $id);

        $last_update = date("d-m-Y H:i", strtotime($last_update));

        $now = date("d-m-Y H:i");

        $diff = abs(strtotime($now) - strtotime($last_update));


        if($diff > 60*60*24*30*12){
            $diff = round($diff / (60*60*24*30*12));
            if($diff == 1){
                return $diff . ' year ago';
            }
            return $diff . ' years ago';
        }
        if($diff > 60*60*24*30){
            $diff = round($diff / (60*60*24*30));
            if($diff == 1){
                return $diff . ' month ago';
            }
            return $diff . ' months ago';
        }
        if($diff > 60*60*24){
            $diff = round($diff / (60*60*24));
            if($diff == 1){
                return $diff . ' day ago';
            }
            return $diff . ' days ago';
        }
        if($diff > 60*60){
            $diff = round($diff / (60*60));
            if($diff == 1){
                return $diff . ' hour ago';
            }
            return $diff . ' hours ago';
        }
        if($diff > 60){
            $diff = round($diff / (60));
            if($diff == 1){
                return $diff . ' minute ago';
            }
            return $diff . ' minutes ago';
        }

        return 'just now';
    }
}
?>