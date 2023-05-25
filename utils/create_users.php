<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

class create_users{
    static function create(PDO $db): bool{

        try {
            $password = password_hash('admin', PASSWORD_DEFAULT);
            $stmt = $db->prepare('INSERT INTO User (fullname, username, email, password, role_id, image_path) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute(array('admin', 'admin', 'admin@gmail.com', $password, 1, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('admin Restivo', 'adminRestivo', 'adminrestivo@gmail.com', $password, 1, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('admin Machado', 'adminMachado', 'adminmachado@gmail.com', $password, 1, User::DEFAULT_IMAGE_PATH));
        
            $password = password_hash('agent', PASSWORD_DEFAULT);
            $stmt = $db->prepare('INSERT INTO User (fullname, username, email, password, role_id, image_path) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute(array('agent', 'agent1', 'agent1@gmail.com', $password, 2, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('agent Mota', 'agentMota', 'agentmota@gmail.com', $password, 2, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('agent Landolt', 'agentLandolt', 'agentlandolt@gmail.com', $password, 2, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('agent Coelho', 'agentCoelho', 'agentcoelho@gmail.com', $password, 2, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('agent Lima', 'agentLima', 'agentlima@gmail.com', $password, 2, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('agent Marco', 'agentMarco', 'agentmarco@gmail.com', $password, 2, User::DEFAULT_IMAGE_PATH));
        
            $password = password_hash('client', PASSWORD_DEFAULT);
            $stmt = $db->prepare('INSERT INTO User (fullname, username, email, password, role_id, image_path) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute(array('client Diniz', 'clientDiniz', 'clientdiniz@gmail.com', $password, 3, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('client Silva', 'clientSilva', 'clientsilva@gmail.com', $password, 3, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('client Santos', 'clientSantos', 'clientsantos@gmail.com', $password, 3, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('client Costa', 'clientCosta', 'clientcosta@gmail.com', $password, 3, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('client Pereira', 'clientPereira', 'clientpereira@gmail.com', $password, 3, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('client Ferreira', 'clientFerreira', 'clientferreira@gmail.com', $password, 3, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('client Carvalho', 'clientCarvalho', 'clientcarvalho@gmail.com', $password, 3, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('client Marques', 'clientMarques', 'clientmarques@gmail.com', $password, 3, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('client Gomes', 'clientGomes', 'clientgomes@gmail.com', $password, 3, User::DEFAULT_IMAGE_PATH));
            $stmt->execute(array('client Coelho', 'clientCoelho', 'jantonioboavista@gmail.com', $password, 3, User::DEFAULT_IMAGE_PATH));

            return true;
        
        } catch (PDOException $e) {
            return false;
        }


    }
}