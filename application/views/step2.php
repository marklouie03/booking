<section class="container">

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    SELECT SCHEDULE
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="<?= base_url('welcome/step3') ?>" method="post" id="form">
                        <?php foreach($schedule_collection as $schedule): ?>
                            <div class="container">
                                
                                <div class="row">
                                    <div class="col">
                                        <!-- Vessel Name  -->
                                        <h3><?= $schedule->name ?></h3>
                                        <p>Schedule Date: <?= date('M. d, Y', strtotime($schedule->date)) ?></p>
                                        <p>Schedule Time: <?= date('h:i A', strtotime($schedule->time)) ?></p>
                                    </div>
                                </div>
                                <?php
                                    if( ! empty($schedule->collection) ) {
                                        /**
                                     * cycle through collection.
                                     */
                                        foreach($schedule->collection as $key => $types) {
                                            if( ! empty($types) ) {
                                                $key = ucwords($key);
                                                echo "<div class='card'>";
                                                echo "<div class='card-header'>";
                                                echo "<h5>{$key}</h5>";
                                                echo "</div>"; // card header
                                                echo "<div class='card-body'>";

                                                echo "<div class='row'>";
                                                foreach($types as $type) {
                                                    $rate = number_format($type->rate, 2);
                                                    $input_name = "section[{$schedule->id}]";
                                                    echo "
                                                    <div class='col'>
                                                        <ul class='list-group'>
                                                            <li class='list-group-item active'>
                                                                <div class='form-check'>
                                                                    <label class='form-check-label'>
                                                                        <input type='radio' class='form-check-input' name='{$input_name}' value='{$type->section_id}'>
                                                                        {$type->section}
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <li class='list-group-item' hidden>{$type->passenger}</li>
                                                            <li class='list-group-item'>{$rate} PHP</li>
                                                        </ul>
                                                    </div>";
                                                }
                                                echo "</div>";
                                                echo "</div>"; // card body
                                                echo "</div>"; // card end
                                            }
                                        }
                                    }
                                ?>
                            </div>

                        <?php endforeach; ?>
                    </form> 
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary float-right" form="form" id="btn-next">Next</button>
                        </div>
                    </div>
                </div>
                <!-- /.card-footer -->
            </div>

        </div>
    </div>

</section>
