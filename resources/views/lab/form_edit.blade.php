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
                                <label for="satuan" class="col-md-2 col-md-offset-1 control-label">Satuan</label>
                                <div class="col-md-8">
                                    <select name="satuan" id="satuan" class="form-control">
                                        <option value="kg">KG</option>
                                        <option value="liter">liter</option>
                                    </select>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="parameter" class="col-md-2 col-md-offset-1 control-label">Parameter</label>
                                <div class="col-md-8">
                                    <textarea type="text" name="parameter" id="parameter" cols="10" rows="10" class="form-control"></textarea>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="hasil" class="col-md-2 col-md-offset-1 control-label">Hasil</label>
                                <div class="col-md-8">
                                    <textarea type="text" name="hasil" id="hasil" cols="10" rows="10" class="form-control"></textarea>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="kesimpulan" class="col-md-2 col-md-offset-1 control-label">Kesimpulan</label>
                                <div class="col-md-8">
                                    <input type="kesimpulan" name="kesimpulan" id="kesimpulan" class="form-control" />
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="grid" class="col-md-2 col-md-offset-1 control-label">Grid</label>
                                <div class="col-md-8">
                                    <input type="grid" name="grid" id="bahan_layak" class="form-control" />
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
