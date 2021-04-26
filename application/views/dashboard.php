<div style="margin-bottom:20px"></div>

<center>
    <div id="startImage">
        <?php $dream = base_url() . "assets/img/girlUniverse.svg" ?>
        <img src="<?= $dream ?>" class="center-block img-responsive" alt="" height="400px">
        <br>&nbsp;
        <h1 style="font-family: modernFont">Maging Malibog Ka!</h1>
    </div>

    <br>


    <div id="goal" style="display:none">
        <div class="col-md-6" id="createImage">
            <img src="<?= base_url() . "assets/img/bookRead.svg" ?>" height="150px" alt="">
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="bg-dark p-5 rounded">
                    <div class="table-responsive">
                        <table class="table table-hovered text-white">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Goal</th>
                                    <th>Start Date</th>
                                    <th>Finish Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $counter = 0 ?>
                                <?php foreach ($dreamTable->result() as $row) { ?>
                                    <?php $counter++ ?>

                                    <tr>
                                        <td><?= $counter ?></td>
                                        <td><?= $row->goal ?></td>
                                        <td><?= $row->start_date ?></td>
                                        <td><?= $row->end_date ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</center>

<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">&#129299; Create a Goal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form id="createForm">
                    <div class="md-form mb-5">
                        <i class="fas fa-lightbulb prefix grey-text"></i>
                        <input type="text" id="myDream" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="defaultForm-email">Your Goal</label>
                    </div>


                    <div class="md-form mb-4">
                        <i class="fas fa-calendar-check prefix grey-text"></i>
                        <input type="date" id="finishDate" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="defaultForm-pass">Finish Date</label>
                    </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button class="btn btn-primary" style="font-size: 25px">&#129321; &nbsp; Submit &nbsp; &#129395;</button>
            </div>
            </form>
        </div>
    </div>
</div>

<?php $createGoal = base_url() . "Dashboard/createGoal" ?>
<?php $refreshTable = base_url() . "Dashboard/refreshTable" ?>

<script>
    $(document).ready(function() {

        function refreshTable() {
            $('tbody').load("<?= $refreshTable ?>");
        }
        var DELAY = 200,
            clicks = 0,
            timer = null;

        $("#createImage").on("click", function(e) {

            clicks++; //count clicks

            if (clicks === 1) {

                timer = setTimeout(function() {

                    $('#modalAdd').modal('toggle'); //perform single-click action    
                    clicks = 0; //after action performed, reset counter

                }, DELAY);

            } else {

                clearTimeout(timer); //prevent single-click action
                $('#goal').fadeOut(); //perform double-click action
                $("#startImage").animate({
                    width: 'toggle'
                }, 2000);
                clicks = 0; //after action performed, reset counter
            }

        })
        $('#createImage').on("dblclick", function(e) {
            e.preventDefault(); //cancel system double-click event
        });

        // goal submit
        $('#createForm').submit(function(e) {
            e.preventDefault();

            // get the form values
            var myGoal = $('#myDream').val();
            var finishDate = $('#finishDate').val();
            console.log("my goal is: " + myGoal, finishDate);
            // submit post request
            $.post("<?= $createGoal ?>", {
                goal: myGoal,
                finish_date: finishDate
            }, function() {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1500
                });

                // close the modal
                $('#modalAdd').modal('toggle');

                refreshTable();
            });
        });

        $('#startImage').click(function() {
            $('#startImage').hide();

            $('#goal').slideDown('slow');
        });
    });
</script>