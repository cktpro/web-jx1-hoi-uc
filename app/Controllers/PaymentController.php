<?php

class PaymentController extends Controller {
    public function cardForm(): void {
        $this->authUser();
        $db = db_portal();
        $config = (new SiteConfig($db))->get();
        $user = (new User($db))->getInfo($_SESSION['username']);
        $this->view('layouts/user', [
            'config'       => $config,
            'user'         => $user,
            'content_view' => 'payment/card',
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

        $db = db_portal();
        $apiKey = (new SiteConfig($db))->get()['keyapi'] ?? '';
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
            (new Payment($db))->logCard($username, $seri, $pin, $type, $value);
            $this->json(['status' => 0, 'msg' => 'Gửi thẻ thành công, đợi 30s - 1p!']);
        }

        $this->json(['status' => 1, 'msg' => 'Gửi thẻ thất bại!']);
    }

    public function bankForm(): void {
        $this->authUser();
        $db = db_portal();
        $config = (new SiteConfig($db))->get();
        $user = (new User($db))->getInfo($_SESSION['username']);
        $bank = explode(';', $config['atmbank'] ?? '');
        $this->view('layouts/user', [
            'config'       => $config,
            'user'         => $user,
            'bank'         => $bank,
            'content_view' => 'payment/bank',
        ]);
    }

    public function momoForm(): void {
        $this->authUser();
        $db = db_portal();
        $config = (new SiteConfig($db))->get();
        $user = (new User($db))->getInfo($_SESSION['username']);
        $momo = explode(';', $config['momo'] ?? '');
        $this->view('layouts/user', [
            'config'       => $config,
            'user'         => $user,
            'momo'         => $momo,
            'content_view' => 'payment/momo',
        ]);
    }

    public function history(): void {
        $this->authUser();
        $db = db_portal();
        $logs = (new Payment($db))->getHistory($_SESSION['username']);
        $config = (new SiteConfig($db))->get();
        $user = (new User($db))->getInfo($_SESSION['username']);
        $this->view('layouts/user', [
            'config'       => $config,
            'user'         => $user,
            'logs'         => $logs,
            'content_view' => 'payment/history',
        ]);
    }
}
