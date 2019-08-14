<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <title>Rajaongkir | AL Gzl</title>
</head>

<body>
    <div class="container">
        <div class="card mt-3">
            <div class="card-header">
                Rajaongkir
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Province</label>
                    <select class="form-control" id="provinsi">
                        <?php foreach ($province as $pro) : ?>
                        <option value="<?= $pro['province_id'] ?>"><?= $pro['province'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kabupaten</label>
                    <select class="form-control" id="kabupaten"></select>
                </div>
                <div class="form-group">
                    <label>Kurir</label>
                    <select class="form-control" id="kurir">
                        <option value="jne">JNE</option>
                        <option value="tiki">TIKI</option>
                        <option value="pos">POS</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Berat</label>
                    <input type="number" class="form-control" id="berat" value="1000" readonly>
                </div>
                <div class="form-group">
                    <label>Ongkir</label>
                    <select class="form-control" id="ongkir"></select>
                </div>
                <!-- <button class="btn btn-primary" onclick="getOngkir()">AMBIL ONGKIR</button> -->

            </div>
            <div class="card-footer">
                Total belanja = Rp.50.000 + Ongkir Rp.<span id="ongkos"></span> = Rp.<span id="total"></span>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>

<script>
    $(document).ready(function() {
        // Ongkir
        function cekongkir() {
            var kab = $('#kabupaten').val();
            var berat = $('#berat').val();
            var kurir = $('#kurir').val();


            $.ajax({
                type: 'POST',
                url: "<?= base_url('rajaongkir/ongkir') ?>",
                data: {
                    'kab_id': kab,
                    'weight': berat,
                    'kurir': kurir
                },
                success: function(data) {
                    $("#ongkir").html(data);
                    getOngkir();
                }
            });
        };

        $("#provinsi").change(function() {
            var prov = $('#provinsi').val();

            $.ajax({
                type: 'GET',
                url: "<?= base_url('rajaongkir/kabupaten') ?>",
                data: 'prov_id=' + prov,
                success: function(data) {
                    $("#kabupaten").html(data);
                }
            });
        });

        $("#kabupaten").change(function() {
            cekongkir();
        });

        $("#kurir").change(function() {
            cekongkir();
        });

        $("#ongkir").change(function() {
            getOngkir();
        });
    });

    function getOngkir() {
        var ongkir = $('#ongkir').val();
        $('#ongkos').text(ongkir);
        var total = parseInt(50000) + parseInt(ongkir);
        $('#total').text(total);
    }
</script>