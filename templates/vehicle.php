<?php
$id = isset($data['id_vehicle']) ? htmlspecialchars($data['id_vehicle']) : '';
$vehicle_name = isset($data['vehicle_name']) ? htmlspecialchars($data['vehicle_name']) : '';
$id_vehicle_type = isset($data['id_vehicle_type']) ? htmlspecialchars($data['id_vehicle_type']) : '';
$vehicle_number = isset($data['vehicle_number']) ? htmlspecialchars($data['vehicle_number']) : '';
$id_vehicle_make = isset($data['id_vehicle_make']) ? htmlspecialchars($data['id_vehicle_make']) : '';
$vehicle_year = isset($data['vehicle_year']) ? htmlspecialchars($data['vehicle_year']) : '';
$id_color = isset($data['id_color']) ? htmlspecialchars($data['id_color']) : '';

?>
<!-- vehicles/create.php -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Vehicles</h1>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="card mt-1">
                <div class="card-header">
                    <h3 class="card-title">Edit vehicle</h3>
                </div>

                <div class="card-body">
                    <form id="vehicleForm">
                        <div class="row">
                            <!-- First Column -->
                            <input type="hidden" name="id_vehicle" value="<?= $id ?>">
                            <div class="col-9 mb-1 d-flex align-items-center" style="margin-left:18px;">
                                <label for="vehicle_name" class="mr-1">Vehicle Name:</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm w-25" id="vehicle_name" name="vehicle_name" value="<?= $vehicle_name ?>">
                            </div>

                            <div class="col-9 mb-1 d-flex align-items-center">
                                <label for="vehicle_number" class="mr-1">Vehicle Number:</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm w-25" id="vehicle_number" name="vehicle_number" value="<?= $vehicle_number ?>">
                            </div>

                            <div class="col-9 mb-1 d-flex align-items-center" style="margin-left: 15px;">
                                <label for="vehicle_make" class="mr-1">Vehicle Makes:</label>
                                <select class="form-control form-control-sm w-25 mr-1" id="vehicle_make" name="vehicle_make" value="<?= $id_vehicle_make ?>">
                                    <option value="">Loading...</option>
                                </select>
                                <label for="vehicle_type" class="mr-1">Vehicle Type:</label>
                                <select class="form-control form-control-sm w-25 mr-1" id="vehicle_type" name="vehicle_type" value="<?= $id_vehicle_type ?>">
                                    <option value="">Loading...</option>
                                </select>
                            </div>
                            <div class="col-9 mb-1 d-flex align-items-center" style="margin-left: 22px;">
                                <label for="id_color" class="mr-1">Vehicle Color:</label>
                                <select class="form-control form-control-sm w-25 mr-1" id="id_color" name="id_color" value="<?= $id_color ?>">
                                    <option value="">Loading...</option>
                                </select>
                            </div>
                            <div class="col-9 mb-1 d-flex align-items-center" style="margin-left: 15px;">
                                <label for="vehicle_year" class="mr-1 ml-3">Vehicle Year:</label>
                                <input autocomplete="off" type="text" class="form-control form-control-sm w-25" id="vehicle_year" name="vehicle_year" value="<?= $vehicle_year ?>">
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

        //save the value of the button that was clicked
        let clickedButton = null;
        $('button[type="submit"]').on('click', function() {
            clickedButton = $(this);
        });

        jQuery.validator.addMethod("usPlate", function(value, element) {
            return this.optional(element) || /^[A-Z0-9]{1,7}$/.test(value.toUpperCase());
        }, "Please enter a valid US license plate (1–7 uppercase letters or numbers).");

        $.ajax({
            url: 'ajax/vehicles/get_colors.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const select = $('#id_color');
                    select.empty();
                    response.data.forEach(function(type) {
                        select.append(`<option value="${type.id_color}">${type.color_name}</option>`);
                    });
                    $('#id_color').val(<?= $id_color ?>);
                } else {
                    alert('Failed to load colors.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('An error occurred while loading vehicle makes.');
            }
        });

        $.ajax({
            url: 'ajax/vehicles/get_vehicle_makes.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const select = $('#vehicle_make');
                    select.empty();
                    response.data.forEach(function(type) {
                        select.append(`<option value="${type.id_vehicle_make}">${type.make_name}</option>`);
                    });
                    $('#vehicle_make').val(<?= $id_vehicle_make ?>);
                } else {
                    alert('Failed to load vehicle makes.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('An error occurred while loading vehicle makes.');
            }
        });

        $.ajax({
            url: 'ajax/vehicles/get_vehicle_types.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    const select = $('#vehicle_type');
                    select.empty();
                    response.data.forEach(function(type) {
                        select.append(`<option value="${type.id_vehicle_type}">${type.vehicle_type}</option>`);
                    });
                    $('#vehicle_type').val(<?= $id_vehicle_type ?>);
                } else {
                    alert('Failed to load vehicle types.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('An error occurred while loading vehicle types.');
            }
        });

        //ajax
        $('#vehicleForm').validate({
            rules: {
                vehicle_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                vehicle_number: {
                    required: true,
                    minlength: 3,
                    maxlength: 50
                },
                vehicle_year: {
                    required: true,
                    length: 4,
                    number: true
                },
                plate_number: {
                    required: true,
                    usPlate: true
                }
            },
            messages: {
                vehicle_name: "Vehicle name must be between 3 and 50 characters",
                vehicle_number: "Vehicle number must be between 3 and 50 characters",
                vehicle_number: "Vehicle year must be a valid date",
                plate_number: {
                    required: "License plate is required.",
                    usPlate: "Enter a valid US license plate (e.g., ABC1234)."
                }
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
                    url: 'ajax/vehicles/vehicle.php',
                    method: 'POST',
                    data: $(form).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            if (clickedButton.data('type') === 'save_new') {
                                window.location.href = 'vehicles/vehicle.php';
                            } else if (clickedButton.data('type') === 'save_return') {
                                window.location.href = 'vehicles/list.php';
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