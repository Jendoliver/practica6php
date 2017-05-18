<!-- READ MESSAGE -->
<div id="readMsg" class="modal fade" role="dialog">
    <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Mensaje de <span id="from" class="msgfield"></span></h4>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="date"><span class="glyphicon glyphicon-chevron-right"/> Fecha de envío: <span id="date" class="msgfield"></span></label>
            </div>
            <div class="form-group">
                <label for="subj"><span class="glyphicon glyphicon-chevron-right"/> Asunto: <span id="subj" class="msgfield"></span></label>
            </div>
            <div class="form-group">
                <label for="body"><span class="glyphicon glyphicon-chevron-right"/> Mensaje:</label>
                <div id="body" class="msgfield well"></div>
            </div>
        </div>
    </div>
    
    </div>
</div>