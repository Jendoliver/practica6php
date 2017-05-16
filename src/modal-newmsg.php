<!-- NEW MESSAGE -->
<div id="newMsg" class="modal fade" role="dialog">
    <div class="modal-dialog">
    
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Nuevo mensaje</h4>
        </div>
        <div class="modal-body">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="to"><span class="glyphicon glyphicon-chevron-right"></span> Destinatario:</label>
                    <select class="form-control" name="to">
                        <?php Utils::fetchUsersOption(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="subject"><span class="glyphicon glyphicon-chevron-right"></span> Asunto:</label>
                    <input type="text" class="form-control" name="subj" placeholder="007" maxlength="50" required>
                </div>
                <div class="form-group">
                    <label for="subject"><span class="glyphicon glyphicon-chevron-right"></span> Mensaje:</label>
                    <textarea name="body" class="form-control" rows="6"></textarea>
                </div>
                <input type="submit" class="btn btn-success btn-block" name="sendmsg" value="Enviar mensaje">
            </form>
        </div>
    </div>
    
    </div>
</div>