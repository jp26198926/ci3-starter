<div class="modal" id="loading2" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" style='font-weight: bold;'>
                    <i class="ace-icon fa fa-spinner fa-spin text-primary bigger"></i>
                    Loading...
                </h4>
            </div>
            <div class="modal-body">

                <div class="progress pos-rel" data-percent="">
                    <div id="loading2_width" class="progress-bar progress-bar-striped active" style="width:100%;">
                        <span id="loading2_label">Processing.... Pleae wait!</span>
                    </div>
                </div>

                <div>
                    <?php
                    $this->load->view('template/qoutes');
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>