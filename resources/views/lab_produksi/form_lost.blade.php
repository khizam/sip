<div class="modal fade" id="modal_form_lost" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg" role="document">
     <form action="#" method="#" class="form-horizontal">
        @csrf
        @method('post')

        <input type="hidden" name="id_produksi" id="id_produksi" />
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group row">
                            <label for="lost" class="col-md-2 col-md-offset-1 control-label">Lost</label>
                            <div class="col-md-8">
                                <input type="number" name="lost" id="lost" class="form-control" value="0">
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-sm btn-flat btn-primary">Simpan</button>
            <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal">Batal</button>
          </div>
        </div>
     </form>
    </div>
</div>
