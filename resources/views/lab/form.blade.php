<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
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
                                <label for="id_bahan" class="col-md-2 col-md-offset-1 control-label">Bahan</label>
                                <div class="col-md-8">
                                    <input name="id_bahan" id="id_bahan" class="form-control" readonly/>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="id_kategori" class="col-md-2 col-md-offset-1 control-label">Kategori</label>
                                <div class="col-md-8">
                                    <input name="id_kategori" id="id_kategori" class="form-control" readonly/>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="id_supplier" class="col-md-2 col-md-offset-1 control-label">Supplier</label>
                                <div class="col-md-8">
                                    <input name="id_supplier" id="id_supplier" class="form-control" readonly/>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="jumlah_bahan" class="col-md-2 col-md-offset-1 control-label">Jumlah Bahan</label>
                                <div class="col-md-8">
                                    <input type="number" name="jumlah_bahan" id="jumlah_bahan" class="form-control" readonly/>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="bahan_layak" class="col-md-2 col-md-offset-1 control-label">Bahan Layak</label>
                                <div class="col-md-8">
                                    <input type="number" name="bahan_layak" id="bahan_layak" class="form-control" />
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="bahan_tidak_layak" class="col-md-2 col-md-offset-1 control-label hidden">Bahan Tidak Layak</label>
                                <div class="col-md-8">
                                    <input type="number" name="bahan_tidak_layak" id="bahan_tidak_layak" class="form-control hidden" />
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                      </div>
                  </div>
              </div>
              <div class="form-group">
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
