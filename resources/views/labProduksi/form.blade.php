<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
      <div class="modal-dialog modal-lg" role="document">
       <form action="" method="post" class="form-horizontal">
          @csrf
          @method('post')

          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <div class="form-group row">
                <label for="nama_grade" class="col-md-2 col-md-offset-1 control-label">Grade</label>
                <div class="col-md-8">
                    <input type="text" name="nama_grade" id="nama_grade" class="form-control" required autofocus>
                    <span class="help-block with-errors"></span>
                </div>
              </div>
              <div class="form-group row">
                <label for="jumalh_produksi" class="col-md-2 col-md-offset-1 control-label">Jumlah produksi</label>
                <div class="col-md-8">
                    <input type="text" name="jumalh_produksi" id="jumalh_produksi" class="form-control" required autofocus>
                    <span class="help-block with-errors"></span>
                </div>
              </div>
              <div class="form-group row">
                <label for="lost" class="col-md-2 col-md-offset-1 control-label">Lost</label>
                <div class="col-md-8">
                    <input type="text" name="lost" id="lost" class="form-control" required autofocus>
                    <span class="help-block with-errors"></span>
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