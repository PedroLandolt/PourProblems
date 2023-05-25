<?php
declare(strict_types=1);

class Department
{
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    static function getDepartment(PDO $db, int $id): Department
    {
        $stmt = $db->prepare('SELECT * FROM Department WHERE id = ?');

        $stmt->execute(array($id));
        $department = $stmt->fetch();

        return new Department($department['id'], $department['name']);
    }

    static function getDepartments(PDO $db): array
    {
        $stmt = $db->prepare('SELECT * FROM Department');
        $stmt->execute();

        $departments = array();
        while ($department = $stmt->fetch()) {
            $departments[] = new Department(
                $department['id'],
                $department['name']
            );
        }

        return $departments;
    }

    static function getDepartment_from_name(PDO $db, string $name): Department
    {
        $stmt = $db->prepare('SELECT * FROM Department WHERE name = ?');

        $stmt->execute(array($name));
        $department = $stmt->fetch();

        return new Department($department['id'], $department['name']);
    }

    static function getAllTicketsFromDepartment(PDO $db, string $department): int
    {
        $stmt = $db->prepare('SELECT COUNT(*) FROM Ticket WHERE department = ?');
        $stmt->execute(array($department));
        $tickets = $stmt->fetch();

        return $tickets['COUNT(*)'];
    }

}
?>