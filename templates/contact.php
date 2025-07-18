<?php
$id = isset($data['id_contact']) ? htmlspecialchars($data['id_contact']) : '';
$first_name = isset($data['first_name']) ? htmlspecialchars($data['first_name']) : '';
$last_name = isset($data['last_name']) ? htmlspecialchars($data['last_name']) : '';
$address = isset($data['address']) ? htmlspecialchars($data['address']) : '';
$phone_number = isset($data['phone_number']) ? htmlspecialchars($data['phone_number']) : '';
$phone_type = isset($data['phone_type']) ? htmlspecialchars($data['phone_type']) : '';
$email = isset($data['email']) ? htmlspecialchars($data['email']) : '';

?>
<!-- contacts/create.php -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Contacts</h1>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card mt-1">
                <div class="card-header">
                    <h3 class="card-title">Edit Contact</h3>
                </div>

                <div class="card-body">
                    <form id="contactForm">
                        <div class="row">
                            <!-- First Column -->
                            <input type="hidden" name="id_contact" value="<?= $id ?>">
                            <div class="col-9 mb-1 d-flex align-items-center" style="margin-left:6px;">
                                <label for="first_name" class="mr-1">First Name:</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm w-25" id="first_name" name="first_name" value="<?= $first_name ?>">
                            </div>

                            <div class="col-9 mb-1 d-flex align-items-center" style="margin-left:9px;">
                                <label for="last_name" class="mr-1">Last Name:</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm w-25" id="last_name" name="last_name" value="<?= $last_name ?>">
                            </div>

                            <div class="col-9 mb-1 d-flex align-items-center" style="margin-left:12px;">
                                <label for="address" class="mr-1 ml-3">Address:</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm w-25" id="address" name="address" value="<?= $address ?>">
                            </div>

                            <div class="col-9 mb-1 d-flex align-items-center">
                                <label for="phone_type" class="mr-1">Phone Type:</label>
                                <select class="form-control form-control-sm w-25 mr-1" id="phone_type" name="phone_type" value="<?= $phone_type ?>">
                                    <option value="">Loading...</option>
                                </select>
                                <label for="phone_number" class="mr-1">Phone Number:</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm w-25" id="phone_number" name="phone_number" value="<?= $phone_number ?>">
                            </div>
                            <div class="col-9 mb-1 d-flex align-items-center">
                                <label for="email" class="mr-1 ml-5">Email:</label>
                                <input autocomplete="off" type="email" class="form-control form-control-sm w-25" id="email" name="email" value="<?= $email ?>">
                            </div>
                            <!-- Submit Button -->
                            <?php
                            if (!$id) {
                            ?>
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <button type="submit" class="btn btn-secondary" data-type="save_new">Save and new</button>
                                    <button type="submit" class="btn btn-primary" data-type="save_return">Save and return</button>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-primary" data-type="save_return">Save and return</button>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
</div>
<script>
    $(document).ready(function() {

        $.validator.addMethod("usPhone", function(value, element) {
            return this.optional(element) || /^\+?\d-\d{3}-\d{3}-\d{4}$/.test(value);
        }, "Please enter a valid phone number (e.g. 1-800-555-1234 or +1-800-555-1234)");

        //save the value of the button that was clicked
        let clickedButton = null;
        $('button[type="submit"]').on('click', function() {
            clickedButton = $(this);
        });

        //get phone types
        $.ajax({
            url: 'ajax/contacts/get_phone_types.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const select = $('#phone_type');
                    select.empty();
                    response.data.forEach(function(type) {
                        select.append(`<option value="${type.id_phone_type}">${type.type_name}</option>`);
                    });
                    $('#phone_type').val(<?= $phone_type ?>);
                } else {
                    alert('Failed to load phone types.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('An error occurred while loading phone types.');
            }
        });

        //ajax
        $('#contactForm').validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                last_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                address: {
                    required: true,
                    minlength: 5,
                    maxlength: 255
                },
                phone_number: {
                    required: true,
                    minlength: 7,
                    maxlength: 20,
                    usPhone: true
                },
                phone_type: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                first_name: "First name must be between 3 and 50 characters",
                last_name: "Last name must be between 3 and 50 characters",
                address: "Address must be between 10 and 255 characters",
                phone_number: "Please enter a valid phone number",
                phone_type: "Please select a phone type",
                email: "Please enter a valid email"
            },
            errorElement: 'span',
            errorClass: 'invalid-feedback',
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
            submitHandler: function(form) {
                // Submit via AJAX
                $.ajax({
                    url: 'ajax/contacts/contact.php',
                    method: 'POST',
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            if (clickedButton.data('type') === 'save_new') {
                                window.location.href = 'contacts/contact.php';
                            } else if (clickedButton.data('type') === 'save_return') {
                                window.location.href = 'contacts/list.php';
                            }
                        } else {
                            alert('Error: ' + response.error);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Unexpected error occurred');
                    }
                });
            }
        });
    });
</script>