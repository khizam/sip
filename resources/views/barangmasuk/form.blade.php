<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
      <div class="modal-dialog modal-lg" role="document">
       <form action="" method="post" class="form-horizontal">
          @csrf
          @method('post')

          {{-- <input type="hidden" name="id_satuan" value="{{ $barangmasuk->id_satuan }}"> --}}
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <div class="form-group row">
                <label for="id_bahan" class="col-md-2 col-md-offset-1 control-label">Bahan</label>
                <div class="col-md-8">
                    <select name="id_bahan" id="id_bahan" class="form-control" required>
                      <option value="">Pilih Bahan</option>
                      @foreach ($bahan as $key => $item)
                          <option value="{{ $item->id_bahan }}" data-satuan="{{ $item->satuan->satuan }}">{{ $item->nama_bahan }}</option>
                      @endforeach
                    </select>
                    <span class="help-block with-errors"></span>
                </div>
                <label for="id_kategori" class="col-md-2 col-md-offset-1 control-label">Kategori</label>
                <div class="col-md-8">
                  <select name="id_kategori" id="id_kategori" class="form-control" required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategori as $kat => $item2)
                        <option value="{{ $item2->id_kategori }}">{{ $item2->nama_kategori }}</option>
                    @endforeach
                  </select>
                  <span class="help-block with-errors"></span>
                </div>
                <label for="id_supplier" class="col-md-2 col-md-offset-1 control-label">Supplier</label>
                <div class="col-md-8">
                  <select name="id_supplier" id="id_supplier" class="form-control" required>
                    <option value="">Pilih Supplier</option>
                    @foreach ($supplier as $key => $item)
                        <option value="{{ $item->id_supplier }}">{{ $item->nama_supplier }}</option>
                    @endforeach
                  </select>
                  <span class="help-block with-errors"></span>
                </div>
                <label for="id_kemasan" class="col-md-2 col-md-offset-1 control-label">Kemasan</label>
                <div class="col-md-8">
                  <select name="id_kemasan" id="id_kemasan" class="form-control" required>
                    <option value="">Pilih Kemasan</option>
                    @foreach ($kemasan as $key => $item)
                        <option value="{{ $item->id_kemasan }}">{{ $item->jenis_kemasan }}</option>
                    @endforeach
                  </select>
                  <span class="help-block with-errors"></span>
                </div>
                <label for="nomor_po" class="col-md-2 col-md-offset-1 control-label">Nomor Po</label>
                <div class="col-md-8">
                    <input type="text" name="nomor_po" id="nomor_po" class="form-control">
                    <span class="help-block with-errors"></span>
                </div>
                <label for="pengirim" class="col-md-2 col-md-offset-1 control-label">Pengirim</label>
                <div class="col-md-8">
                    <input type="text" name="pengirim" id="pengirim" class="form-control">
                    <span class="help-block with-errors"></span>
                </div>
                <label for="penerima" class="col-md-2 col-md-offset-1 control-label">Penerima</label>
                <div class="col-md-8">
                    <input type="text" name="penerima" id="penerima" class="form-control">
                    <span class="help-block with-errors"></span>
                </div>
                <label for="netto" class="col-md-2 col-md-offset-1 control-label">Netto</label>
                <div class="col-md-8">
                    <input type="text" name="netto" id="netto" class="form-control">
                    <span class="help-block with-errors"></span>
                </div>
                <label for="kendaraan" class="col-md-2 col-md-offset-1 control-label">Kendaraan</label>
                <div class="col-md-8">
                    <input type="text" name="kendaraan" id="kendaraan" class="form-control">
                    <span class="help-block with-errors"></span>
                </div>
              </div>
              <div class="form-group row">
                <label for="jumlah_bahan" class="col-md-2 col-md-offset-1 control-label">Jumlah Bahan</label>
                <div class="col-md-6">
                    <input type="number" name="jumlah_bahan" id="jumlah_bahan" class="form-control" value="0">
                    <span class="help-block with-errors"></span>
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" name="satuan_bahan" id="satuan_bahan" readonly>
                </div>
              </div>

            </div>
            <div class="modal-footer">
              <button class="btn btn-sm btn-flat btn-primary" id="tambah">Simpan</button>
              <button type="button" class="btn btn-sm btn-flat btn-default" data-dismiss="modal">Batal</button>
            </div>
          </div>
       </form>
      </div>
</div>
