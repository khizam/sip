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
                <label for="id_produk" class="col-md-2 col-md-offset-1 control-label">Produk</label>
                <div class="col-md-8">
                    <select name="id_produk" id="id_produk" class="form-control" required>
                      <option value="">Pilih Produk</option>
                      @foreach ($produk as $key => $item)
                          <option value="{{ $key }}">{{ $item }}</option>
                      @endforeach
                    </select>
                    <span class="help-block with-errors"></span>
                </div>
              </div>
              <div class="form-group row">
                <label for="jumlah" class="col-md-2 col-md-offset-1 control-label">Jumlah Produk</label>
                <div class="col-md-8">
                    <input type="number" name="jumlah" id="jumlah" class="form-control" value="0">
                    <span class="help-block with-errors"></span>
                </div>
              </div>
              <div class="form-group row">
                <label for="id_satuan" class="col-md-2 col-md-offset-1 control-label">Satuan</label>
                <div class="col-md-8">
                    <select name="id_satuan" id="id_satuan" class="form-control" required>
                      <option value="">Pilih Satuan</option>
                      @foreach ($satuan as $sat => $items)
                          <option value="{{ $sat }}">{{ $items }}</option>
                      @endforeach
                    </select>
                    <span class="help-block with-errors"></span>
                </div>
              </div>
              <div class="form-group row">
                <label for="id_jenisproduksi" class="col-md-2 col-md-offset-1 control-label">Jenis Produksi</label>
                <div class="col-md-8">
                    <select name="id_jenisproduksi" id="id_jenisproduksi" class="form-control" required>
                      <option value="">Pilih Jenis Produksi</option>
                      @foreach ($jenisproduksi as $jen => $items)
                          <option value="{{ $jen }}">{{ $items }}</option>
                      @endforeach
                    </select>
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
