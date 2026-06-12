<div class="card">
    <div class="card-header"><h4><i class="fa fa-credit-card"></i> Nạp thẻ cào</h4></div>
    <div class="card-body">
        <div id="msg"></div>
        <div class="form-group">
            <label>Loại thẻ</label>
            <select id="cardType" class="form-control">
                <option value="VIETTEL">Viettel</option>
                <option value="MOBIFONE">Mobifone</option>
                <option value="VINAPHONE">Vinaphone</option>
                <option value="VIETNAMOBILE">Vietnamobile</option>
                <option value="GMOBILE">Gmobile</option>
            </select>
        </div>
        <div class="form-group">
            <label>Mệnh giá</label>
            <select id="cardValue" class="form-control">
                <option value="10000">10,000đ</option>
                <option value="20000">20,000đ</option>
                <option value="50000">50,000đ</option>
                <option value="100000">100,000đ</option>
                <option value="200000">200,000đ</option>
                <option value="500000">500,000đ</option>
            </select>
        </div>
        <div class="form-group">
            <label>Số seri</label>
            <input type="text" id="cardSeri" class="form-control" placeholder="Nhập số seri thẻ">
        </div>
        <div class="form-group">
            <label>Mã thẻ</label>
            <input type="text" id="cardCode" class="form-control" placeholder="Nhập mã thẻ">
        </div>
        <button class="btn btn-success" onclick="submitCard()">Nạp thẻ</button>
    </div>
</div>
<script>
function submitCard() {
    $.post('/user/ajax/payment/card', {
        cardType: $('#cardType').val(),
        cardValue: $('#cardValue').val(),
        cardSeri: $('#cardSeri').val(),
        cardCode: $('#cardCode').val(),
    }, function(r) {
        var cls = r.status === 0 ? 'success' : 'danger';
        $('#msg').html('<div class="alert alert-' + cls + '">' + r.msg + '</div>');
    }, 'json');
}
</script>
