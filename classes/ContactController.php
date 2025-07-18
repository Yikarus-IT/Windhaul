<?php
class ContactController implements GenericController
{
    private Database $db;

    public function __construct()
    {
        $config = new Config(BASE_PATH . '/config.php');

        // Access values
        $dbHost = $config->get('db_host');
        $dbUser = $config->get('db_user');
        $debugMode = $config->get('debug', true); // fallback true if missing

        $this->db = new Database(
            $dbHost,
            $config->db_name,
            $dbUser,
            $config->db_pass,
            $debugMode
        );
    }

    public function getAll(): array
    {
        return $this->db->fetchAll("
            SELECT
                c.id_contact,
                c.first_name,
                c.last_name,
                c.address,
                c.phone_number,
                pt.type_name AS phone_type,
                c.email,
                c.date_created,
                c.date_modified
            FROM
                contacts c
            LEFT JOIN
                phonetypes pt ON c.phone_type = pt.id_phone_type
            WHERE
                c.is_deleted = 0
            ORDER BY
                c.last_name, c.first_name
        ");
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetchOne("SELECT * FROM contacts WHERE id_contact = ?", [$id]);
    }

    public function createContact(array $data): int
    {
        $sql = "INSERT INTO contacts (first_name, last_name, address, phone_number, phone_type, email, date_created, date_modified)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        return $this->db->insert($sql, [
            $data['first_name'],
            $data['last_name'],
            $data['address'],
            $data['phone_number'],
            $data['phone_type'],
            $data['email'],
            time(),
            time()
        ]);
    }

    public function updateContact(array $data): bool
    {
        $sql = "
            UPDATE
                contacts
            SET
                first_name = ?,
                last_name = ?,
                address = ?,
                phone_number = ?,
                phone_type = ?,
                email = ?,
                date_modified = ?
            WHERE
                id_contact = ?";
        return $this->db->execute($sql, [
            $data['first_name'],
            $data['last_name'],
            $data['address'],
            $data['phone_number'],
            $data['phone_type'],
            $data['email'],
            time(),
            $data['id_contact']
        ]);
    }

    public function delete(int $id): bool
    {
        return $this->db->execute("UPDATE contacts SET is_deleted = 1, date_modified = ? WHERE id_contact = ?", [time(), $id]);
    }

    public function getPhoneTypes(): array
    {
        return $this->db->fetchAll("
            SELECT
                *
            FROM
                phonetypes
        ");
    }
}
