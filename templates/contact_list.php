<!-- Main content area -->

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Contacts List</h1>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <p>This page lists all the contact's information.</p>
        </div>
        <table id="contactsTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <?php
                    if (UserController::getRoleName() != 'Viewer') {
                    ?>
                        <th class="no-sort">Actions</th>
                    <?php
                    }
                    ?>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Phone Type</th>
                    <th>Email</th>
                    <th>Date Created</th>
                    <th>Date Modified</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact): ?>
                    <tr>
                        <?php
                        if (UserController::getRoleName() != 'Viewer') {
                        ?>
                            <td class="text-center position-relative">
                                <div class="dropdown">
                                    <button class="btn btn-link p-0" type="button" id="actionMenu<?= $contact['id_contact'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionMenu<?= $contact['id_contact'] ?>">
                                        <?php
                                        if (UserController::hasPermission('contacts.edit')) {
                                        ?>
                                            <li>
                                                <a class="dropdown-item" href="contacts/contact.php?id=<?= urlencode($contact['id_contact']) ?>">
                                                    <i class="fas fa-pen"></i> Edit
                                                </a>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if (UserController::hasPermission('contacts.delete')) {
                                        ?>
                                            <li>
                                                <a class="dropdown-item text-danger delete-contact" href="ajax/contacts/delete.php?id=<?= urldecode($contact['id_contact']) ?>" data-id="<?= $contact['id_contact'] ?>">
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
                        <td><?= htmlspecialchars($contact['first_name']) ?></td>
                        <td><?= htmlspecialchars($contact['last_name']) ?></td>
                        <td><?= htmlspecialchars($contact['address']) ?></td>
                        <td><?= htmlspecialchars($contact['phone_number']) ?></td>
                        <td><?= htmlspecialchars($contact['phone_type']) ?></td> <!-- We can replace with label later -->
                        <td><?= htmlspecialchars($contact['email']) ?></td>
                        <td><?= date('Y-m-d', $contact['date_created']) ?></td>
                        <td><?= date('Y-m-d', $contact['date_modified']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
<script>
    //Create datatable
    $(document).ready(function() {

        $(document).on('click', '.delete-contact', function(e) {
            e.preventDefault();

            const $link = $(this);
            const contactId = $link.data('id');
            const table = $('#contactsTable').DataTable();


            if (!confirm('Are you sure you want to delete this contact?')) {
                return;
            }

            $.ajax({
                url: 'ajax/contacts/delete.php',
                type: 'POST',
                data: {
                    id: contactId
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
                    alert('An error occurred while trying to delete the contact.');
                }
            });
        });
    });
</script>