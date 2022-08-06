<div class="modal fade" id="modal_form_ket" tabindex="-1" role="dialog" aria-labelledby="modal-form">
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
                      <div class="row">
                          <div class="col-md-12">
                              <label for="keterangan" class="col-md-2 col-md-offset-1 control-label">Keterangan</label>
                              <div class="col-md-8">
                                  <textarea type="text" name="keterangan" id="keterangan" cols="3" rows="3" class="form-control"></textarea>
                                  <span class="help-block with-errors"></span>
                              </div>
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
