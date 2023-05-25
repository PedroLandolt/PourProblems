<?php
declare(strict_types=1);

class Role
{
    public int $id;
    public string $sigla;

    public function __construct(int $id, string $sigla)
    {
        $this->id = $id;
        $this->sigla = $sigla;
    }

    static function getRole(PDO $db, int $id): Role
    {
        $stmt = $db->prepare('SELECT id, sigla FROM Role WHERE id = ?');

        $stmt->execute(array($id));
        $role = $stmt->fetch();

        return new Role(
            $role['id'],
            $role['sigla']
        );
    }
}
?>