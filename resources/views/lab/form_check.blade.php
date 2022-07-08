<div class="modal fade" id="modal-form-check" tabindex="-1" role="dialog" aria-labelledby="modal-form">
      <div class="modal-dialog modal-lg" role="document">
       <form action="#" method="#" class="form-horizontal">
          @csrf
          @method('put')

          <input type="hidden" name="id_lab" id="id_lab" />
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="bahan_tdk_layak" class="col-md-2 col-md-offset-1 control-label">Status</label>
                            <div class="col-md-4 custom-control custom-radio mt-1" style="margin-top: .5rem">
                                <input type="radio" id="status_lab" name="status" class="custom-control-input" value="reject">
                                <label class="custom-control-label" for="status_lab">Reject</label>
                            </div>
                            <div class="col-md-4 custom-control custom-radio" style="margin-top: .5rem">
                                <input type="radio" id="status_lab2" name="status" class="custom-control-input" value="accepted">
                                <label class="custom-control-label" for="status_lab2">Accepted</label>
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
