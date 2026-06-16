<?php

class PaymentController extends Controller {
    public function napknbForm(): void {
        $this->authUser();
        $user = (new User(db_portal()))->getInfo($_SESSION['username']);
        $this->view('layouts/user', [
            'config'       => siteconfig_load(),
            'user'         => $user,
            'content_view' => 'user/napknb',
        ]);
    }

    public function cardAjax(): void {
        $this->authUser();
        $username = $_SESSION['username'];
        $seri  = trim($_POST['cardSeri'] ?? '');
        $pin   = trim($_POST['cardCode'] ?? '');
        $type  = trim($_POST['cardType'] ?? '');
        $value = (int)($_POST['cardValue'] ?? 0);

        if (!$seri || !$pin || !$type || !$value) {
            $this->json(['status' => 1, 'msg' => 'Vui lòng điền đầy đủ thông tin thẻ']);
        }

        $cfg    = siteconfig_load();
        $apiKey = $cfg['keyapi'] ?? '';
        $content = '72834d18c8ed1ec2a67cca2356c019ec';
        $url = "https://thesieutoc.net/chargingws/v2?APIkey={$apiKey}&mathe={$pin}&seri={$seri}&type={$type}&menhgia={$value}&content={$content}";

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HEADER         => 0,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);

        if (($result['status'] ?? '') === '00' || ($result['status'] ?? '') === 'thanhcong') {
            (new Payment(db_portal()))->logCard($username, $seri, $pin, $type, $value);
            $this->json(['status' => 0, 'msg' => 'Gửi thẻ thành công, vui lòng đợi 30 giây đến 1 phút!']);
        }

        $this->json(['status' => 1, 'msg' => 'Gửi thẻ thất bại, vui lòng kiểm tra lại thông tin!']);
    }

    public function history(): void {
        $this->authUser();
        $user = (new User(db_portal()))->getInfo($_SESSION['username']);
        $logs = (new Payment(db_portal()))->getHistory($_SESSION['username']);
        $this->view('layouts/user', [
            'config'       => siteconfig_load(),
            'user'         => $user,
            'logs'         => $logs,
            'content_view' => 'user/payment-history',
        ]);
    }
}
