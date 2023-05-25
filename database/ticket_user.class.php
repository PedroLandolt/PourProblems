<?php
declare(strict_types=1);

class Ticket_User
{
    public int $client_id;
    public int $agent_id;
    public int $ticket_id;

    public function __construct(int $client_id, int $agent_id, int $ticket_id)
    {
        $this->client_id = $client_id;
        $this->agent_id = $agent_id;
        $this->ticket_id = $ticket_id;
    }

    static function getTicket_User(PDO $db, int $id): Ticket_User
    {
        $stmt = $db->prepare('SELECT * FROM Ticket_User WHERE ticket_id = ?');

        $stmt->execute(array($id));
        $ticket_user = $stmt->fetch();

        return new Ticket_User($ticket_user['client_id'], $ticket_user['agent_id'], $ticket_user['ticket_id']);
    }

    // maybe missing static function getArtistAlbums(PDO $db, int $id) : array

    static function getTickets_from_User(PDO $db, int $client_id): array
    {
        $stmt = $db->prepare('SELECT * FROM Ticket_User WHERE client_id = ?');

        $stmt->execute(array($client_id));

        $tickets = [];

        while ($ticket = $stmt->fetch()) {
            $tickets[] = new Ticket_User(
                intval($ticket['client_id']),
                intval($ticket['agent_id']),
                intval($ticket['ticket_id'])
            );
        }
        return $tickets;
    }

    static function getAssigned_tickets(PDO $db, int $agent_id): array
    {
        $stmt = $db->prepare('SELECT * FROM Ticket_User WHERE agent_id = ?');

        $stmt->execute(array($agent_id));

        $tickets = [];

        while ($ticket = $stmt->fetch()) {
            $tickets[] = new Ticket_User(
                intval($ticket['client_id']),
                intval($ticket['agent_id']),
                intval($ticket['ticket_id'])
            );
        }
        return $tickets;
    }

    static function getAllTickets_User(PDO $db): array
    {
        $stmt = $db->prepare('SELECT * FROM Ticket_User');

        $stmt->execute();

        $tickets_user = array();

        while ($ticket_user = $stmt->fetch()) {
            $tickets_user[] = new Ticket_User(
                intval($ticket_user['client_id']),
                intval($ticket_user['agent_id']),
                intval($ticket_user['ticket_id'])
            );
        }
        return $tickets_user;
    }

    // Function that gets all tickets that are assigned to a department
    static function getTickets_from_department(PDO $db, string $department): array
    {
        $stmt = $db->prepare('SELECT * FROM Ticket_User WHERE ticket_id IN (SELECT id FROM Ticket WHERE department = ?)');

        $stmt->execute(array($department));

        $tickets_user = array();

        while ($ticket_user = $stmt->fetch()) {
            $tickets_user[] = new Ticket_User(
                intval($ticket_user['client_id']),
                intval($ticket_user['agent_id']),
                intval($ticket_user['ticket_id'])
            );
        }
        return $tickets_user;
    }

    static function getTickets_from_Agent(PDO $db, int $agent_id): array
    {
        $stmt = $db->prepare('SELECT * FROM Ticket_User WHERE agent_id = ?');

        $stmt->execute(array($agent_id));

        $tickets = [];

        while ($ticket = $stmt->fetch()) {
            $tickets[] = new Ticket_User(
                intval($ticket['client_id']),
                intval($ticket['agent_id']),
                intval($ticket['ticket_id'])
            );
        }
        return $tickets;
    }
    
}
?>