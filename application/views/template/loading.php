<div class="modal" id="loading" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">				
                <h4 class="modal-title" style='font-weight: bold;'>
                <i class="ace-icon fa fa-spinner fa-spin text-primary bigger"></i>                    
                    Loading...
                </h4>
            </div>   
            <div class="modal-body">
                
                <div class="progress">
                    <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                        Request is being processed... Please wait!
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