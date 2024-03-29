<div class="modal fade" id="modal-form-edit-lab" tabindex="-1" role="dialog" aria-labelledby="modal-form">
      <div class="modal-dialog modal-lg" role="document">
       <form action="#" method="#" class="form-horizontal">
          @csrf
          @method('post')

          <input type="hidden" name="id_lab" id="id_lab" />
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
                                <label for="id_bahan" class="col-md-2 col-md-offset-1 control-label">Kode Barang Masuk</label>
                                <div class="col-md-8">
                                    <input name="kd_barangmasuk" id="kd_barangmasuk" class="form-control" readonly/>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="satuan" class="col-md-2 col-md-offset-1 control-label">Nama Bahan</label>
                                <div class="col-md-8">
                                    <input name="bahan" id="bahan" class="form-control" readonly>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="satuan" class="col-md-2 col-md-offset-1 control-label">Satuan</label>
                                <div class="col-md-8">
                                    <input name="satuan" id="satuan" class="form-control" readonly>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="hasil" class="col-md-2 col-md-offset-1 control-label">Hasil</label>
                                <div class="col-md-8">
                                    <textarea name="hasil" id="hasil" cols="3" rows="3" class="form-control"></textarea>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="kesimpulan" class="col-md-2 col-md-offset-1 control-label">Kesimpulan</label>
                                <div class="col-md-8">
                                    <textarea name="kesimpulan" id="kesimpulan" class="form-control" ></textarea>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="grid" class="col-md-2 col-md-offset-1 control-label">Grade</label>
                                <div class="col-md-8">
                                    <input name="grid" id="grid" class="form-control">
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
