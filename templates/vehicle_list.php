<!-- Main content area -->

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Vehicles List</h1>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <p>This page lists all the vehicle's information.</p>
        </div>
        <table id="vehiclesTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <?php
                    if (UserController::getRoleName() != 'Viewer') {
                    ?>
                        <th class="no-sort">Actions</th>
                    <?php
                    }
                    ?>
                    <th>Vehicle Name</th>
                    <th>Vehicle Type</th>
                    <th>Vehicle Number</th>
                    <th>Vehicle Make</th>
                    <th>Date Created</th>
                    <th>Date Modified</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vehicles as $vehicle): ?>
                    <tr>
                        <?php
                        if (UserController::getRoleName() != 'Viewer') {
                        ?>
                            <td class="text-center position-relative">
                                <div class="dropdown">
                                    <button class="btn btn-link p-0" type="button" id="actionMenu<?= $vehicle['id_vehicle'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionMenu<?= $vehicle['id_vehicle'] ?>">
                                        <?php
                                        if (UserController::hasPermission('vehicles.edit')) {
                                        ?>
                                            <li>
                                                <a class="dropdown-item" href="vehicles/vehicle.php?id=<?= urlencode($vehicle['id_vehicle']) ?>">
                                                    <i class="fas fa-pen"></i> Edit
                                                </a>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if (UserController::hasPermission('vehicles.delete')) {
                                        ?>
                                            <li>
                                                <a class="dropdown-item text-danger delete-vehicle" href="ajax/vehicles/delete.php?id=<?= urldecode($vehicle['id_vehicle']) ?>" data-id="<?= $vehicle['id_vehicle'] ?>">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </td>
                        <?php
                        }
                        ?>
                        <td><i class="fas fa-circle" style="color: <?= $vehicle['hex_code'] ?>;"></i> <?= htmlspecialchars($vehicle['vehicle_name']) ?></td>
                        <td><?= htmlspecialchars($vehicle['vehicle_type']) ?></td>
                        <td><?= htmlspecialchars($vehicle['vehicle_number']) ?></td>
                        <td><?= htmlspecialchars($vehicle['make_name']) ?></td>
                        <td><?= date('Y-m-d', $vehicle['date_created']) ?></td>
                        <td><?= date('Y-m-d', $vehicle['date_modified']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
<script>
    //Create datatable
    $(document).ready(function() {

        $(document).on('click', '.delete-vehicle', function(e) {
            e.preventDefault();

            const $link = $(this);
            const vehicleId = $link.data('id');
            const table = $('#vehiclesTable').DataTable();


            if (!confirm('Are you sure you want to delete this vehicle?')) {
                return;
            }

            $.ajax({
                url: 'ajax/vehicles/delete.php',
                type: 'POST',
                data: {
                    id: vehicleId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Find and remove the row
                        const row = $link.closest('tr');
                        table.row(row).remove().draw();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while trying to delete the vehicle.');
                }
            });
        });
    });
</script>