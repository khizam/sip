<div class="modal fade" id="modal_edit_detail" tabindex="-1" role="dialog" aria-labelledby="modal-form">
      <div class="modal-dialog modal-lg" role="document">
       <form action="#" method="#" class="form-horizontal">
          @csrf
          @method('post')

          <input type="hidden" name="id_detail" id="id_detail"/>
          <input type="hidden" name="id_produksi" id="id_produksi"/>
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
                                <label for="parameter" class="col-md-2 col-md-offset-1 control-label">Nama Bahan</label>
                                <div class="col-md-8">
                                    <select class="form-control select2" style="width: 100%;" name="id_bahan" id="id_bahan">
                                        <option>Pilih Bahan</option>
                                        @foreach ($bahan as $item)
                                        <option value="{{ $item->id_bahan }}">{{ $item->nama_bahan }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block with-errors"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="grid" class="col-md-2 col-md-offset-1 control-label">Jumlah</label>
                                <div class="col-md-8">
                                    <input type="number_format" name="jumlah" id="jumlah" class="form-control" />
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
