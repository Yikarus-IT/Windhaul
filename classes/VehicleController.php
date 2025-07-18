<?php
class VehicleController implements GenericController
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
                v.id_vehicle as id_vehicle,
                vt.vehicle_type as vehicle_type,
                v.vehicle_name as vehicle_name,
                v.vehicle_number as vehicle_number,
                v.id_vehicle_make as id_vehicle_make,
                m.make_name as make_name,
                c.color_name as color_name,
                c.hex_code as hex_code,
                v.date_created as date_created,
                v.date_modified as date_modified
            FROM
                vehicles v
            LEFT JOIN
                vehicle_types vt
            ON
                vt.id_vehicle_type = v.id_vehicle_type
            LEFT JOIN
                colors c
            ON
                v.id_color = c.id_color
            LEFT JOIN
                vehicle_makes m
            ON
                v.id_vehicle_make = m.id_vehicle_make
            WHERE
                v.is_deleted = 0
            ORDER BY
                v.vehicle_name
        ");
    }

    public function getById(int $id): ?array
    {
        return $this->db->fetchOne("SELECT * FROM vehicles WHERE id_contact = ?", [$id]);
    }

    public function createVehicle(array $data): int
    {
        $sql = "INSERT INTO vehicles (vehicle_name, vehicle_number, id_vehicle_make, id_vehicle_type, vehicle_year, id_vehicle_model, id_color, date_created, date_modified)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        return $this->db->insert($sql, [
            $data['vehicle_name'],
            $data['vehicle_number'],
            $data['id_vehicle_make'],
            $data['id_vehicle_type'],
            $data['id_vehicle_model'],
            $data['id_color'],
            $data['vehicle_year'],
            time(),
            time()
        ]);
    }

    public function updateVehicle(array $data): bool
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
        return $this->db->execute("UPDATE vehicles SET is_deleted = 1, date_modified = ? WHERE id_vehicle = ?", [time(), $id]);
    }

    public function getVehicleMakes(): array
    {
        return $this->db->fetchAll("
            SELECT
                *
            FROM
                vehicle_makes
        ");
    }

    public function getVehicleTypes(): array
    {
        return $this->db->fetchAll("
            SELECT
                *
            FROM
                vehicle_types
        ");
    }

    public function getColors(): array
    {
        return $this->db->fetchAll("
            SELECT
                *
            FROM
                colors
        ");
    }
}
