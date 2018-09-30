<section class="container">

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    SELECT A TRIP
                </div>
                <!-- /.card-header -->

                <div class="card-body">
                    <form action="<?= base_url('welcome/step2') ?>" method="post" id="form">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="origin">Origin</label>
                                    <select name="origin" id="origin" class="form-control" onchange="get_destination(this)">
                                    <?php 
                                    foreach($ports as $port) {
                                        echo "<option value='{$port->id}'>{$port->name}</option>";
                                    }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="destination">Destination</label>
                                    <select name="destination" id="destination" class="form-control">
                                        
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label" for="travel_type">
                                        <input type="radio" class="form-control" name="travel_type" value="oneway" checked>
                                        One Way
                                    </label>
                                    <label class="control-label" for="travel_type">
                                        <input type="radio" class="form-control" name="travel_type" value="round_trip">
                                        Round Trip
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Date and time range:</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input class="form-control pull-right" id="reservationtime" name="date" type="text">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="adult">Adult</label>
                                    <input type="number" name="adult" class="form-control" value="1">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="children">Children</label>
                                    <input type="number" name="children" class="form-control" value="0">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="Infant">Infant</label>
                                    <input type="number" name="infant" class="form-control" value="0">
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <button class="btn btn-primary" form="form">Next</button>
                            </div>
                        </div>
                    </div>
                </div>             

            </div>

            

        </div>
    </div>

</section>

<script>
    $(document).ready(() => {
        $('#origin').change();
        $('input[name="travel_type"]')[0].click();
    });

    $('input[name="travel_type"]').on('change', (e) => {
        if( e.target.value === 'oneway' ) {
            $('#reservationtime').daterangepicker({
                singleDatePicker: true,
                minDate: minDate
            })
        } else {
            $('#reservationtime').daterangepicker({
                minDate: minDate
            })
        }
    });

    function get_destination( e ) {
        let origin = $(e).find('option:selected').val();
        $.ajax({
            type: "GET",
            url : "<?= base_url('welcome/get_destination/') ?>" + origin,
            beforeSend: () => { 
                $('#destination option').remove();
                $('#destination').append("<option>Loading...<option>"); 
            },
            success: (result) => {
                let data = JSON.parse(result);
                $('#destination option').remove();
                for(destination of data) {
                    $('#destination').append(`<option value="${destination.id}">${destination.name}</option>`);
                }
            }
        });
    }
    
</script>